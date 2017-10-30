<?php

namespace tests\codeception\frontend\unit\components;

use Yii;
use tests\codeception\backend\unit\fixtures\CurrencyFixture;
use tests\codeception\frontend\unit\DbTestCase;

use frontend\components\Currency as CurrencyComponent;

class CurrencyTest extends DbTestCase
{

    /**
     * Тестируем функцию округления цены до чистой (которая показывается пользователю)
     */
    public function testCeil() {
        // инициализация компонента
        $cc = new CurrencyComponent();

        $this->assertEquals( $cc->ceil(14.123, 2), 14.13 );

        $this->assertEquals( $cc->ceil('14.123', 2), 14.13 );

        $this->assertEquals( $cc->ceil(14.5, 2), 14.5 );

        $this->assertEquals( $cc->ceil(14.005, 2), 14.01 );

        $this->assertEquals( $cc->ceil(14.00, 2), 14 );

        $this->assertEquals( $cc->ceil(14, 2), 14 );

        // string instead
        $this->assertEquals( $cc->ceil('invalid_value', 2), 0 );

    }


    /**
     * Тестируем исключение если валюта пользователя не задана
     *
     * @expectedException \Exception
     */
    public function testConvertWithoutUserCurrency() {
        // инициализация компонента
        $currencyComponent = new CurrencyComponent();

        $productCur = $currencyComponent->getCurrencyByCode('USD');

        $this->expectException(\Exception::class);
        $currencyComponent->convert(100, $productCur);
    }

    /**
     * Тестируем конвертер цены из одной валюты в другую
     */
    public function testConvert() {

        // инициализация компонента
        $currencyComponent = new CurrencyComponent();



        // Если на сайте выбрана валюта AZN, а у товара валюта USD

        $productCur = $currencyComponent->getCurrencyByCode('USD');
        $currencyComponent->setUserCurrency($currencyComponent->getCurrencyByCode('AZN'));

        $resultPrice = $currencyComponent->convert(100, $productCur);

        $this->assertEquals( $resultPrice, 171 );



        // Если на сайте выбрана валюта USD, а у товара валюта USD

        $productCur = $currencyComponent->getCurrencyByCode('USD');
        $currencyComponent->setUserCurrency($currencyComponent->getCurrencyByCode('USD'));

        $resultPrice = $currencyComponent->convert(100, $productCur);

        $this->assertEquals( $resultPrice, 100 );



        // Если на сайте выбрана валюта USD, а у товара валюта AZN

        $productCur = $currencyComponent->getCurrencyByCode('AZN');
        $currencyComponent->setUserCurrency($currencyComponent->getCurrencyByCode('USD'));

        $resultPrice = $currencyComponent->convert(100, $productCur);

        $this->assertEquals( $resultPrice, 58.48 );



        // Если на сайте выбрана валюта USD, а у товара валюта EUR

        $productCur = $currencyComponent->getCurrencyByCode('EUR');
        $currencyComponent->setUserCurrency($currencyComponent->getCurrencyByCode('USD'));

        $resultPrice = $currencyComponent->convert(100, $productCur);

        $this->assertEquals( $resultPrice, 111.12 );

        //echo $this->currency->convert($product->price);

    }

    public function fixtures()
    {
        return [
            'currency' => [
                'class' => CurrencyFixture::className(),
                'dataFile' => '@tests/codeception/backend/unit/fixtures/data/components/currency.php',
            ],
        ];
    }
}