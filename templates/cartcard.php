<div class="product" id="products">
    <div class="row">
        <div class="col-md-3">
            <img class="img-fluid mx-auto d-block image" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($cartItem[4]) ?>">
        </div>
        <div class="col-md-8">
            <div class="info">
                <div class="row">
                    <div class="col-md-5 product-name">
                        <div class="product-name">
                            <a href="#" class="goingdark"><?= $cartItem[1] ?></a>
                            <div class="product-info">
                                <div class="goingdark">Display: <span class="value goingdark">5 inch</span></div>
                                <div class="goingdark">RAM: <span class="value goingdark">4GB</span></div>
                                <div class="goingdark">Memory: <span class="value goingdark">32GB</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 quantity">
                        <label class="goingdark" for="quantity">Anzahl:</label>

                        <input onchange="aendern(<?= $cartItem[0] ?>, <?= $anzahl ?>)" id="auswahl<?= $anzahl ?>" type="number" value="<?= $cartItem[6] ?>" class="form-control quantity-input artikelpr row-border-light goingdark">
                    </div>
                    <script>
                        const artikelp = document.getElementsByClassName("artikelp");
                        const artikelpr = document.getElementsByClassName("artikelpr");
                        const artikelteile = document.getElementsByClassName("artikelpr");

                        function aendern(a, b) {

                            var anzahl = 'auswahl' + b;
                            var e = document.getElementById(anzahl).value;
                            var ajax = new XMLHttpRequest();

                            ajax.open("GET", "templates/ajax.php?amount=" + e + "&productid=" + a, true);
                            ajax.send();


                            let preis = 0;
                            for (let i = 0; i < artikelp.length; i++) {

                                preis = preis + parseFloat(artikelp[i].textContent.replace(',', "")) * parseFloat(artikelpr[i].value);
                            }
                            var endpreis = preis.toLocaleString("en-EN");

                            var gesamtteile = 0;
                            for (let i = 0; i < artikelteile.length; i++) {
                                gesamtteile = parseInt(artikelteile[i].value) + gesamtteile;
                            }

                            var delpreis = parseFloat(document.getElementById("delprice").textContent);
                            var cartdelpreis = <?= $cartItem[7] ?>;

                            document.getElementById("artikelpreiss").textContent = endpreis.fixed(2).replace(/(<([^>]+)>)/gi, "") + "€";
                            if (document.getElementById("artikelpreiss").textContent == "0€") {
                                document.getElementById("artikelpreiss").textContent = "0.00€";
                            }
                            document.getElementById("artikelteile").textContent = gesamtteile;
                            document.getElementById("warenkorbanzahl").textContent = "Warenkorb (" + gesamtteile + ")";

                            ajax.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    if (this.response.includes("delete")) {
                                        document.getElementById("products").remove();
                                        var s = this.response;
                                        var k = s.split(" ");

                                        document.getElementById("delprice").textContent = k[1] + "€";
                                        // Bei der Funktion ist die Bedingung, dass alle Produkte Lieferkosten haben.
                                        if (document.getElementById("delprice").textContent == "0€") {
                                            document.getElementById("totalprice").textContent = "0.00€";
                                            document.getElementById("emptycartjs").classList = "container emptycart goingdark";
                                            document.getElementById("emptycartjs").innerHTML = "Ups, dein Warenkorb ist leer!";


                                            document.getElementById("buybutton").classList.add("disabled");
                                            document.getElementById("buybutton").classList.remove("btn-success");
                                            document.getElementById("buybutton").classList.add("btn-secondary");

                                        }

                                    }
                                }
                            }
                            document.getElementById("totalprice").textContent = (delpreis + preis).toLocaleString("en-EN") + "€";
                        }
                    </script>
                    <div class="col-md-3 price">
                        <span class="artikelp goingdark"><?php
                                                            $cost = number_format($cartItem[3], 2);
                                                            echo "$cost";


                                                            ?>€</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>