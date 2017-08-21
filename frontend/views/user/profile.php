<div class="account_edit">
    <div>
        <h2><?= Yii::t('app', 'Registration');?></h2>
        <div class="form">
            <form action="" method="post" id="regForm">

                <ul>
                    <li <?= isset($profileErrors['firstname']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Name'); ?></span>
                        <div>
                            <input type="text" name="firstname" value="<?= $profile->firstname; ?>">
                            <?php if (isset($profileErrors['firstname'])) { ?>
                                <strong><?= $profileErrors['firstname'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>

                    <li <?= isset($profileErrors['lastname']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Surname'); ?></span>
                        <div>
                            <input type="text" name="lastname" value="<?= $profile->lastname; ?>">
                            <?php if (isset($profileErrors['lastname'])) { ?>
                                <strong><?= $profileErrors['lastname'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>

                    <li <?= isset($customerErrors['email']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Email'); ?></span>
                        <div>
                            <input type="text" name="email" value="<?= $customer->email; ?>">
                            <?php if (isset($customerErrors['email'])) { ?>
                                <strong><?= $customerErrors['email'][0]; ?></strong>
                            <?php } ?>
                        </div>
                        <em><?= Yii::t('app', 'We’ll send your order confirmation here'); ?></em>
                    </li>

                    <li <?= isset($profileErrors['phone1']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Phone'); ?></span>
                        <div>
                            <input type="text" name="phone1" value="<?= $profile->phone1; ?>">
                            <?php if (isset($profileErrors['phone1'])) { ?>
                                <strong><?= $profileErrors['phone1'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>

                    <li <?= isset($profileErrors['phone2']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Alternative phone'); ?></span>
                        <div>
                            <input type="text" name="phone2" value="<?= $profile->phone2; ?>">
                            <?php if (isset($profileErrors['phone2'])) { ?>
                                <strong><?= $profileErrors['phone2'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>

                    <li <?= isset($customerErrors['password']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Password'); ?></span>
                        <div>
                            <input type="password"
                                   name="password"
                                   value="">
                            <?php if (isset($customerErrors['password'])) { ?>
                                <strong><?= $customerErrors['password'][0]; ?></strong>
                            <?php } ?>
                        </div>
                        <em><?= Yii::t('app', 'Must be 8 or more letters and contain at least 1 number'); ?></em>
                    </li>

                    <li <?= isset($customerErrors['repeat_password']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Confirm password'); ?></span>
                        <div>
                            <input type="password"
                                   name="confirm_password"
                                   value="">
                            <?php if (isset($customerErrors['repeat_password'])) { ?>
                                <strong><?= $customerErrors['repeat_password'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>


                    <li <?= isset($addressErrors['country_id']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Country'); ?></span>
                        <div>
                            <select class="form-control" id="countryField" name="country_id"
                                    title="<?= Yii::t('app', 'Country'); ?>">
                                <option value=""><?= Yii::t('app', 'Country'); ?></option>
                                <?php foreach ($countries as $id => $name) { ?>
                                    <option <?= $id == $address->country_id ? 'selected="selected"' : ''; ?> value="<?=$id?>"><?=$name?></option>
                                <?php } ?>
                            </select>
                            <?php if (isset($addressErrors['country_id'])) { ?>
                                <strong><?= $addressErrors['country_id'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>

                    <li <?= isset($addressErrors['zone_id']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Region'); ?></span>
                        <div>
                            <select class="form-control" id="zoneField"
                                    title="<?= Yii::t('app', 'Region'); ?>"
                                    name="zone_id">
                                <option value=""><?= Yii::t('app', 'Region'); ?></option>
                            </select>
                            <?php if (isset($addressErrors['zone_id'])) { ?>
                                <strong><?= $addressErrors['zone_id'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>

                    <li <?= isset($addressErrors['city']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'City'); ?></span>
                        <div>
                            <input type="text" name="city" value="<?= $address->city; ?>">
                            <?php if (isset($addressErrors['city'])) { ?>
                                <strong><?= $addressErrors['city'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>

                    <li <?= isset($addressErrors['address_1']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Address'); ?></span>
                        <div>
                            <input type="text" name="address" value="<?= $address->city; ?>">
                            <?php if (isset($addressErrors['address_1'])) { ?>
                                <strong><?= $addressErrors['address_1'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>

                    <li <?= isset($addressErrors['postcode']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Postal code'); ?></span>
                        <div>
                            <input type="text" name="postal_code" value="<?= $address->postcode; ?>">
                            <?php if (isset($addressErrors['postcode'])) { ?>
                                <strong><?= $addressErrors['postcode'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>

                    <li <?= isset($addressErrors['org']) ? 'class="error"' : ''; ?>>
                        <span><?= Yii::t('app', 'Organization'); ?></span>
                        <div>
                            <input type="text" name="org" value="<?= $address->company; ?>">
                            <?php if (isset($addressErrors['org'])) { ?>
                                <strong><?= $addressErrors['org'][0]; ?></strong>
                            <?php } ?>
                        </div>
                    </li>

                </ul>
                <div class="submit">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken()?>">
                    <button type="submit"><?= Yii::t('app', 'Register'); ?></button>
                </div>
            </form>
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