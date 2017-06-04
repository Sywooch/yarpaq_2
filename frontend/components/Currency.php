<?php
namespace frontend\components;


use Yii;
use yii\base\Component;
use yii\base\Exception;
use common\models\Currency as CurrencyModel;
use common\models\CurrencySearch;

/**
 * Class Currency
 * @package frontend\components
 *
 * Впитывает в себя все валюты с их данными, текущую валюту выбранную на сайте
 * а также некоторые полезные методы
 */

class Currency extends Component
{

    /**
     * Валюта на которой пользователь смотрит цены на сайте
     *
     * @var CurrencyModel
     */
    protected $userCurrency;

    /**
     * @var Array
     */
    protected $currencies;

    public function init() {
        parent::init();

        $this->setDefaultCurrency();
    }

    /**
     * Конвертация цены на основе валюты товара и валюты выбранной на сайте
     *
     * @param $price
     * @param CurrencyModel $sourceCurrency
     * @return float
     * @throws Exception
     */
    public function convert($price, CurrencyModel $sourceCurrency) {
        if ($this->getUserCurrency() == null) {
            throw new Exception('User Currency was not set');
        }

        // конвертируем
        $convertedPrice = $price * ( $sourceCurrency->value / $this->getUserCurrency()->value );

        // округляем в соответствии с количеством цифр после запятой
        $cleanPrice = $this->ceil($convertedPrice, $this->getUserCurrency()->decimal_place);
        return $cleanPrice;
    }

    /**
     * Возвращает массив моделей всех АКТИВНЫХ валют имеющихся на сайте
     *
     * @return array
     */
    public function getCurrencies() {
        if ($this->currencies == null) {
            $currencySearch = new CurrencySearch();

            $this->currencies = $currencySearch->search(
                [
                    'status' => CurrencyModel::STATUS_ACTIVE
                ]
            )->getModels();
        }

        return $this->currencies;
    }

    /**
     * Использует метод getCurrency для получения массива всех валют
     * и затем выбирает из этого списка модель валюты с соответствующим кодом
     *
     * @param $code
     * @return mixed
     */
    public function getCurrencyByCode($code) {
        $currencies = $this->getCurrencies();

        foreach ($currencies as $currency) {
            if ($currency->code == $code) {
                return $currency;
            }
        }
    }

    /**
     * Округляет с учетом количества цифр после запятой
     *
     * @param $price float Цена товара
     * @param int $decimal_place Количество цифр после запятой
     * @return float
     */
    public function ceil($price, $decimal_place = 0) {
        $helper = pow(10, $decimal_place);
        return ceil($price * ( $helper )) / $helper;
    }

    public function setUserCurrency(CurrencyModel $currency) {
        $this->userCurrency = $currency;
    }

    public function getUserCurrency() {
        if ($this->userCurrency) {
            return $this->userCurrency;
        } else {
            $session = Yii::$app->session;

            if ($session->get('currency_id')) {
                $currency = CurrencyModel::findOne($session->get('currency_id'));
                if ($currency) {
                    $this->setUserCurrency($currency);
                }
            }
        }

        return $this->userCurrency;
    }

    protected function setDefaultCurrency() {
        $this->userCurrency = $this->getCurrencies()[0];
    }

}