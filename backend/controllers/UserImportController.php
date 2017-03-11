<?php

namespace backend\controllers;

use common\models\Profile;
use common\models\User;
use Yii;
use yii\base\Exception;
use yii\web\Controller;

class UserImportController extends Controller
{


    public function actionIndex() {
        ini_set('memory_limit', '-1');

        $this->importUsers();
        $this->importCustomers();
    }

    // МЕТОДЫ ДЛЯ СИНХРОНИЗАЦИИ ДАННЫХ СО СТАРОГО САЙТА

    /**
     * Правила импорта
     *
     * Если пользователь уже ассоциирован, то данные надо модифицировать
     * Если пользователь новый, то создать новую модель в базе и сохранить ассоциацию
     * Удаленные пользователи не трогаются
     *
     * Пользователя забираются из двух разных таблиц
     *
     * Таблица customers
     * Тут есть и продавцы и покупатели.
     * В данном скрипте не прописываются роли пользователей
     *
     *
     * Таблица users
     * Тут есть админы и продавцы
     *
     */


    private function getCustomerAssoc() {

        $sql = 'SELECT `old_id`, `new_id` FROM `user_assoc` WHERE `type` = "customer"';

        $assocs = Yii::$app->db->createCommand($sql)->queryAll();

        $ids = [];
        foreach ($assocs as $assoc) {
            $ids[ $assoc['old_id'] ] = $assoc['new_id'];
        }

        return $ids;
    }

    private function getUserAssoc() {

        $sql = 'SELECT `old_id`, `new_id` FROM `user_assoc` WHERE `type` = "user"';

        $assocs = Yii::$app->db->createCommand($sql)->queryAll();

        $ids = [];
        foreach ($assocs as $assoc) {
            $ids[ $assoc['old_id'] ] = $assoc['new_id'];
        }

        return $ids;
    }

    private function importCustomers()
    {

        // достаем ассоциации Customers
        $customerAssoc = $this->getCustomerAssoc();

        // запрос для получения покупателей и псевдо продавцов из таблицы Customer
        $sql = 'SELECT * FROM `oc_customer`';

        // получаем всех покупателей
        $users = Yii::$app->db_old->createCommand($sql)->queryAll();


        $errors = [
            'models' => [],
            'profiles' => []
        ];

        foreach ($users as $user) {
            $user['date_added'] = strtotime($user['date_added']);

            $tr = Yii::$app->db->beginTransaction();

            $old_user_id = $user['customer_id'];
            $asso = false;

            // по умолчанию создаем модель
            $model = new User();

            // если ассоциация есть, то обновляем данные
            if (in_array($old_user_id, array_keys($customerAssoc))) {
                $tmp = User::findOne($customerAssoc[ $old_user_id ]);

                if ($tmp) {
                    $model = $tmp;
                    $asso = true;
                }
            }

            // инициализация профайла
            $profile = $model->profile ? $model->profile : new Profile();



            // вставляем данные
            // - основная часть
            $model->username = strtolower($user['email']);
            $model->auth_key = '';
            $model->password_hash = $user['password'];
            $model->confirmation_token = $user['token'];
            $model->status = $user['status'];
            $model->superadmin = 0;
            $model->created_at = $user['date_added'];
            $model->updated_at = $user['date_added'];
            $model->salt = $user['salt'];
            $model->registration_ip = $user['ip'];
            $model->bind_to_ip = '';
            $model->email = strtolower($user['email']);
            $model->email_confirmed = $user['approved'];


            // вставляем данные
            // - профайл пользователя
            $profile->user_id = $model->id;
            $profile->firstname = $user['firstname'];
            $profile->lastname = $user['lastname'];
            $profile->org = '';
            $profile->phone1 = $user['telephone'];
            $profile->phone2 = $user['alt_telephone'];
            $profile->fax = $user['fax'];

            // объединяем сохранение модели, профайла и ассоциации в транзакцию
            try {

                // сохраняем модель
                $modelSaved = $model->save();
                if (!$modelSaved) {
                    $errors['models'][$old_user_id] = $model;
                    throw new Exception('model #'.$old_user_id.' not saved');
                }


                // сохраняем профайл
                $profile->user_id = $model->id;
                $profileSaved = $profile->save();
                if (!$profileSaved) {
                    $errors['profiles'][$old_user_id] = $profile;
                    throw new Exception('profile #'.$old_user_id.' not saved');
                }


                // сохраняем ассоциацию, если ее не было
                if (!$asso) {
                    $replace_sql = 'REPLACE INTO `user_assoc` (`old_id`, `new_id`, `type`) VALUES ('.$old_user_id.', '.$model->id.', "customer")';
                    Yii::$app->db->createCommand($replace_sql)->execute();
                }

                $tr->commit();

            } catch (Exception $e) {
                $tr->rollBack();
            }


        }

        echo '<h1>Customers import</h1>';
        $this->printReport($errors);
    }

    private function importUsers()
    {
        // достаем ассоциации Users
        $userAssoc = $this->getUserAssoc();

        // запрос для получения админов и продавцов из таблицы User
        $sql = 'SELECT * FROM `oc_user`';

        // выполняем запрос
        $users = Yii::$app->db_old->createCommand($sql)->queryAll();

        $errors = [
            'models' => [],
            'profiles' => []
        ];

        foreach ($users as $user) {
            $user['date_added'] = strtotime($user['date_added']);

            $tr = Yii::$app->db->beginTransaction();

            $old_user_id = $user['user_id'];
            $asso = false;

            // по умолчанию создаем модель
            $model = new User();

            // если ассоциация есть, то обновляем данные
            if (in_array($old_user_id, array_keys($userAssoc))) {
                $tmp = User::findOne($userAssoc[ $old_user_id ]);

                if ($tmp) {
                    $model = $tmp;
                    $asso = true;
                }
            }

            // инициализация профайла
            $profile = $model->profile ? $model->profile : new Profile();



            // вставляем данные
            // - основная часть
            $model->username = $user['username'];
            $model->auth_key = '';
            $model->password_hash = $user['password'];
            $model->confirmation_token = null;
            $model->status = $user['status'];
            $model->superadmin = 0;
            $model->created_at = $user['date_added'];
            $model->updated_at = $user['date_added'];
            $model->salt = $user['salt'];
            $model->registration_ip = $user['ip'];
            $model->bind_to_ip = '';
            $model->email = strtolower($user['email']);
            $model->email_confirmed = 1;


            // вставляем данные
            // - профайл пользователя
            $profile->user_id = $model->id;
            $profile->firstname = $user['firstname'];
            $profile->lastname = $user['lastname'];
            $profile->org = $user['org'];
            $profile->phone1 = $user['telephone'];
            $profile->phone2 = '';
            $profile->fax = '';


            // объединяем сохранение модели, профайла и ассоциации в транзакцию
            try {

                // сохраняем модель
                $modelSaved = $model->save();
                if (!$modelSaved) {
                    $errors['models'][$old_user_id] = $model;
                    throw new Exception('model #' . $old_user_id . ' not saved');
                }

                $this->setRole($model->id, $user['user_group_id']);



                // сохраняем профайл
                $profile->user_id = $model->id;
                $profileSaved = $profile->save();
                if (!$profileSaved) {
                    $errors['profiles'][$old_user_id] = $profile;
                    throw new Exception('profile #'.$old_user_id.' not saved');
                }


                // сохраняем ассоциацию, если ее не было
                if (!$asso) {
                    $replace_sql = 'REPLACE INTO `user_assoc` (`old_id`, `new_id`, `type`) VALUES ('.$old_user_id.', '.$model->id.', "user")';
                    Yii::$app->db->createCommand($replace_sql)->execute();
                }

                $tr->commit();

            } catch (Exception $e) {
                $tr->rollBack();
            }

        }

        echo '<h1>Users import</h1>';
        $this->printReport($errors);
    }

    private function printReport($errors) {
        // Print report
        if (count($errors['models'])) {
            echo '<h2>Accounts report</h2>';
            echo '<table>';

            echo '<tr><td><b>Customer ID</b></td><td><b>Errors (total error models '.count($errors['models']).')</b></td></tr>';

            foreach ($errors['models'] as $oid => $err_model) {
                echo '<tr>';

                echo '<td>#'.$oid.'</td>';

                echo '<td>';

                foreach ($err_model->getErrors() as $error) {
                    echo implode(', ', $error).'<br>';
                } unset($error);

                echo '</td>';



                echo '</tr>';
            }

            echo '</table>';
        }


        // Print report
        if (count($errors['profiles'])) {
            echo '<h2>User profiles report</h2>';
            echo '<table>';

            echo '<tr><td><b>Customer ID</b></td><td><b>Errors (total error profiles '.count($errors['profiles']).')</b></td></tr>';

            foreach ($errors['profiles'] as $oid => $err_model) {
                echo '<tr>';

                echo '<td>#'.$oid.'</td>';

                echo '<td>';

                foreach ($err_model->getErrors() as $error) {
                    echo implode(', ', $error).'<br>';
                } unset($error);

                echo '</td>';



                echo '</tr>';
            }

            echo '</table>';
        }
    }


    public function setRole($user_id, $role_id) {
        $roles = [
            1 => 'admin',
            2 => 'seller'
        ];

        if (!isset($roles[$role_id])) {
            throw new Exception('Unknown role');
        }

        $role = $roles[$role_id];

        Yii::$app->db->createCommand('REPLACE INTO {{%auth_assignment}} VALUES ("'.$role.'", '.$user_id.', '.time().')')->execute();
    }

}