<div class="product_block">
    <header>

        <!-- Breadcrumbs -->
        <?= $this->render('_breadcrumb', [
            'category' => $category,
            'productsCount' => $pages->totalCount
        ]); ?>
        <!-- Breadcrumbs END -->

        <div class="trend_searches">
            <p>Trend axtarışlar:</p>
            <ul>
                <li><a href="#">adidas</a></li>
                <li><a href="#">nike</a></li>
                <li><a href="#">puma</a></li>
                <li><a href="#">klassik kişi ayaqqabıları</a></li>
                <li><a href="#">nike airmax</a></li>
                <li><a href="#">puma rihanna</a></li>
                <li><a href="#">tərliklər</a></li>
                <li><a href="#">bot ayakkabı</a></li>
            </ul>
        </div>
    </header>
    <div class="product_header_mobile">
        <h3>Ayyaqqabılar: İdman</h3>
        <ul>
            <li><a href="#" class="sort"><span>Çeşİdlə</span></a></li>
            <li><a href="#" class="filtre"><span>Fİlter</span></a></li>
        </ul>
        <p>Tapılan məhsullar   1 026</p>
    </div>
    <div class="product_list_wrapper">

        <aside class="aside_filter">

            <?php
            $children = $category->getChildren()->all();

            if (count($children)) { ?>
            <div class="aside_categories">
                <h3>Alt bolmeler</h3>
                <ul>

                <?php foreach ($category->getChildren()->all() as $childCategory) { ?>
                    <li>
                        <a href="<?= $childCategory->url; ?>">
                            <span><?= $childCategory->title; ?></span><em>300 //TODO</em>
                        </a>
                    </li>
                <?php } ?>

                </ul>
            </div>
            <?php } ?>

            <div class="filters_block">
                <section>
                    <h3><span>Qiymət aralığı</span></h3>
                    <div>
                        <input type="text" id="price_slider" name="" value="" />
                        <div class="price_form">
                            <input type="text" value="0">
                            <input type="text" value="5000">
                            <button type="submit">AXTAR</button>
                        </div>
                    </div>
                </section>
                <section>
                    <h3><span>Marka</span><a href="#">təmİzlə</a></h3>
                    <div>
                        <ul class="checkboxes">
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>Puma</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>Adidas</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>Reebok</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>Nike</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>Asics</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                        </ul>
                    </div>
                </section>
                <section>
                    <h3><span>Rəng</span><a href="#">təmİzlə</a></h3>
                    <div>
                        <ul class="checkboxes colored">
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <i style="background: #ff5656"></i>
                                    <span>Qırmızı</span>
                                    <strong>12</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <i style="background: #20ad63"></i>
                                    <span>Yaşıl</span>
                                    <strong>354</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <i style="background: #ffd800"></i>
                                    <span>Sarı</span>
                                    <strong>33</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <i style="background: #393939"></i>
                                    <span>Qara</span>
                                    <strong>4</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <i style="background: #567fff"></i>
                                    <span>Göy</span>
                                    <strong>421</strong>
                                </label>
                            </li>
                        </ul>
                    </div>
                </section>
                <section>
                    <h3><span>Ölçü</span><a href="#">təmİzlə</a></h3>
                    <div>
                        <ul class="checkboxes">
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>35</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>36</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>37</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>38</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>39</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>40</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>41</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>42</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                        </ul>
                    </div>
                </section>
                <section>
                    <h3><span>İstahsalçı ölkə</span><a href="#">təmİzlə</a></h3>
                    <div>
                        <ul class="checkboxes">
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>Türkiyə</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>Tayland</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>Çin</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <em></em>
                                    <span>Kitay</span>
                                    <strong>234</strong>
                                </label>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </aside>
        <div class="product_list">
            <header>
                <div class="first">
                    <h2>Kişi ayaqqabıları <span>(1200 məhsul)</span></h2>
                    <div class="sort_by">
                        <a href="#">Çeşidlə: <span>Əvvəlcə yenilər</span></a>
                        <ul>
                            <li><a href="inner_list.html" class="active">Əvvəlcə yenilər</a></li>
                            <li><a href="inner_list.html">Əvvəlcə kohnelar</a></li>
                            <li><a href="inner_list.html">Əvvəlcə bahalar</a></li>
                            <li><a href="inner_list.html">Əvvəlcə kohnelar</a></li>
                        </ul>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="second">
                    <div class="applied_filters">
                        <ul>
                            <li>
                                <span>Qiymət:</span>
                                <strong>120 azn — 300 azn<a href="#"></a></strong>
                            </li>
                            <li>
                                <span>Brand:</span>
                                <strong>Adidas<a href="#"></a></strong>
                            </li>
                            <li>
                                <span>Rəng:</span>
                                <strong>Qırmızı<a href="#"></a></strong>
                            </li>
                            <li>
                                <span>Ölçü:</span>
                                <strong>40<a href="#"></a></strong>
                            </li>
                        </ul>
                    </div>
                    <a href="#" class="clear_filtre">Fİlterİ təmİzlə</a>
                </div>
            </header>
            <div class="product_result_list">
                <?php
                if (isset($products)) {
                    foreach ($products as $product) {
                        echo $this->render('_product', [
                            'product' => $product
                        ]);
                    }
                }
                ?>
            </div>
            <div class="more_products"><a href="#">Daha çox göstər</a></div>
            <footer>
                <span>Axtardığızı tapa bildinizmi?</span>
                <a href="#">Bəli</a>
                <a href="#">Xeyir</a>
            </footer>
        </div>
    </div>

</div>