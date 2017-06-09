<div class="widgets-content">
    <div class="overlap-content"></div>
    <div class="v-padding-30">

        <div class="container no-padding">
            <div class="row">

                <aside class="col-sm-4 col-md-3 hidden-xs">
                    <div class="infoMenuBox light-gray_bg">
                        <div class="list-infoMenu">
                            <div class="v-padding-5">
                                <div class="title green sizex14"><span>HESAB</span> </div>

                            </div>
                        </div>
                    </div>
                </aside>
                <div class="col-sm-8 col-md-9 inner-content">
                    <div class="row margin-right-0">
                        <div class="gray-box clearfix">
                            <div class="registration-title">
                                <?= Yii::t('app', 'Registration');?>
                                <a class="registration-video-link pink2 hide">
                                    <i class="youtube-icon"></i>
                                    <div>Qeydiyyatdan keçməyin qaydaları</div>
                                </a>
                            </div>

                            <!-- Registration Steps -->
                            <ul class="list-inline registration-step clearfix">
                                <li class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="reg-icon">
                                        <img src="img/regStep1.png">
                                    </div>
                                    <div class="green dejavu-bold">
                                        <div class=" size20">1</div>
                                        Qeydiyyatdan keçin
                                    </div>
                                    <div >Saytda qeydiyyatdan keçin
                                        "Indi Al" duyməsini tiklayaraq
                                    </div>
                                </li>
                                <li class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="reg-icon ">
                                        <img src="img/regStep2.png">
                                    </div>
                                    <div class="green dejavu-bold ">
                                        <div class="size20">2</div>
                                        Qeydiyyatdan keçin
                                    </div>
                                    <div>Saytda qeydiyyatdan keçin
                                        "Indi Al" duyməsini tiklayaraq
                                    </div>
                                </li>
                                <li class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="reg-icon ">
                                        <img src="img/regStep3.png">
                                    </div>
                                    <div class="green dejavu-bold ">
                                        <div class="size20">3</div>
                                        Qeydiyyatdan keçin
                                    </div>
                                    <div>Saytda qeydiyyatdan keçin
                                        "Indi Al" duyməsini tiklayaraq
                                    </div>
                                </li>
                                <li class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="reg-icon ">
                                        <img src="img/regStep4.png">
                                    </div>
                                    <div class="green dejavu-bold">
                                        <div class=" size20">4</div>
                                        Qeydiyyatdan keçin
                                    </div>
                                    <div >Saytda qeydiyyatdan keçin
                                        "Indi Al" duyməsini tiklayaraq
                                    </div>
                                </li>

                            </ul>
                        </div>

                        <p class="text-center v-margin-15">Əgər siz artıq qeydiyyatdan keçmisinizsə, zəhmət olmasa, login page daxil olun.</p>

                        <div class="registration-info gray-box clearfix">
                            <form action="" method="post" id="regForm">

                                <div>
                                    <h4 class="registration-title"><?= Yii::t('app', 'Personal information'); ?></h4>
                                    <div class="forms">
                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($profileErrors['firstname']) ? 'error' : ''; ?>">
                                                <input type="text" class="form-control" name="firstname"
                                                       placeholder="<?= Yii::t('app', 'Name'); ?>"
                                                       value="<?= $profile->firstname; ?>">
                                                <span class="required">*</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($profileErrors['lastname']) ? 'error' : ''; ?>">
                                                <input type="text" class="form-control" name="lastname"
                                                       placeholder="<?= Yii::t('app', 'Surname'); ?>"
                                                       value="<?= $profile->lastname; ?>">
                                                <span class="required">*</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($customerErrors['email']) ? 'error' : ''; ?>">
                                                <input type="text" class="form-control" name="email"
                                                       placeholder="<?= Yii::t('app', 'Email'); ?>"
                                                       value="<?= $customer->email; ?>">
                                                <span class="required">*</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($profileErrors['phone1']) ? 'error' : ''; ?>">
                                                <input type="text" class="form-control" name="phone1"
                                                       placeholder="<?= Yii::t('app', 'Phone'); ?>"
                                                       value="<?= $profile->phone1; ?>">
                                                <span class="required">*</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($profileErrors['phone2']) ? 'error' : ''; ?>">
                                                <input type="text" class="form-control" name="phone2"
                                                       placeholder="<?= Yii::t('app', 'Alternative phone'); ?>"
                                                       value="<?= $profile->phone2; ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div >
                                    <h4 class="registration-title"><?= Yii::t('app', 'Address'); ?></h4>
                                    <div class="forms">

                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($addressErrors['country_id']) ? 'error' : ''; ?>">
                                                <label class="select">
                                                    <select class="form-control" id="countryField" name="country_id"
                                                            title="<?= Yii::t('app', 'Country'); ?>">
                                                        <option value=""><?= Yii::t('app', 'Country'); ?></option>
                                                        <?php foreach ($countries as $id => $name) { ?>
                                                            <option <?= $id == $address->country_id ? 'selected="selected"' : ''; ?> value="<?=$id?>"><?=$name?></option>
                                                        <?php } ?>
                                                    </select>
                                                </label>
                                                <span class="required">*</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($addressErrors['zone_id']) ? 'error' : ''; ?>">
                                                <label class="select">
                                                    <select class="form-control" id="zoneField" title="<?= Yii::t('app', 'Region'); ?>" name="zone_id">
                                                        <option value=""><?= Yii::t('app', 'Region'); ?></option>
                                                    </select>
                                                </label>
                                                <span class="required">*</span>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>


                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($addressErrors['city']) ? 'error' : ''; ?>">
                                                <input type="text" class="form-control" name="city"
                                                       placeholder="<?= Yii::t('app', 'City'); ?>"
                                                       value="<?= $address->city; ?>">
                                                <span class="required">*</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($addressErrors['address_1']) ? 'error' : ''; ?>">
                                                <input type="text" class="form-control" name="address"
                                                       placeholder="<?= Yii::t('app', 'Address'); ?>"
                                                       value="<?= $address->address_1; ?>">
                                                <span class="required">*</span>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($addressErrors['postcode']) ? 'error' : ''; ?>">
                                                <input type="text" class="form-control" name="postal_code"
                                                       placeholder="<?= Yii::t('app', 'Postal code'); ?>"
                                                       value="<?= $address->postcode; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($addressErrors['org']) ? 'error' : ''; ?>">
                                                <input type="text" class="form-control" name="org"
                                                       placeholder="<?= Yii::t('app', 'Organization'); ?>"
                                                       value="<?= $address->company; ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div >
                                    <h4 class="registration-title"><?= Yii::t('app', 'Password'); ?></h4>
                                    <div class="forms">
                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($customerErrors['password']) ? 'error' : ''; ?>">
                                                <input type="password" class="form-control" name="password" placeholder="<?= Yii::t('app', 'Password'); ?>">
                                                <span class="required">*</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group <?= isset($customerErrors['repeat_password']) ? 'error' : ''; ?>">
                                                <input type="password" class="form-control" name="confirm_password" placeholder="<?= Yii::t('app', 'Confirm password'); ?>">
                                                <span class="required">*</span>
                                            </div>
                                        </div>


                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="confirmed-registration">
                                    <div class="forms">

                                        Mən <a href="" class="green">Məxfilik Siyasəti</a> oxudum və razıyam
                                        <div class="inline-block ">
                                            <input class="radio" id="radio6" name="radio6" type="checkbox">
                                            <label for="radio6"></label>
                                        </div>
                                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken()?>">
                                        <button type="submit" class="btn btn-green"><?= Yii::t('app', 'Continue'); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var zones = {};

    <?php foreach ($zones as $country_id => $_zones) { ?>
    zones[<?= $country_id ?>] = {};
    <?php foreach ($_zones as $id => $name) { ?>
    zones[<?= $country_id ?>][<?=$id?>] = "<?=$name?>";
    <?php } ?>
    <?php } ?>
</script>