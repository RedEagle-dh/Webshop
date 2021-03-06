 <?php
    
     function addProductToCart($productId, $userid) {
         /*$routeParts = explode('/', $route);
         $productId = (int) $routeParts[3];*/
         $sql = "INSERT INTO cart SET userid = $userid, productid = $productId, amount = 1, created = time(now())";
         $result = db_query($sql);
         return $result;
     }

     function addProductToCartFromProductSite($route, $userid) {
         $routeParts = explode('/', $route);
         $productId = (int) $routeParts[3];
         $sql = "INSERT INTO cart SET userid = $userid, productid = $productId, amount = 1, created = time(now())";
         $result = db_query($sql);
         return $result;
     }

    function getProdcutIDThatWantsToBeAddedToCart($route)
    {
        $routeParts = explode('/', $route);
        $productId = (int) $routeParts[3];
        return $productId;
     }

     function countCartItems($userid) {
        $sql = "SELECT sum(amount) from cart where userid = $userid;";
         
         $cartResult = db_query($sql);

         $cartItems = mysqli_fetch_column($cartResult);

         return $cartItems;
     }

     function getCartItemsForUser():array {
        $userid = getCurrentUserId();
        $sql = "SELECT productid, titel, beschreibung, preis, picture, id, amount, lieferkosten, userid, discount FROM cart JOIN produkte ON(cart.productid = produkte.artnr) WHERE userid = " . $userid;
         $results = db_query($sql);
         if ($results === false) {
             return[];
         }
         $found = [];
         while ($row = mysqli_fetch_row($results)) {
             $found[] = $row;
         }
         return $found;
     }

     function bindCartItemsToUser(int $sourceId, int $targetId) {
         $sql = "UPDATE cart SET userid = $targetId WHERE userid = $sourceId";
         db_query($sql);

     }


     function getCartPrice()
     {
         $userid = getCurrentUserId();
         
         $sql = "SELECT sum((produkte.preis - ((produkte.preis*produkte.discount)/100))*cart.amount) as gesamtpreis FROM cart, produkte WHERE productid = artnr AND userid = $userid;";
         $result = db_query($sql);
         
         while ($row = mysqli_fetch_row($result)) {
             $sum = $row[0];
         }
         if ($sum == 0) {
             return "0";
         } else {
             
             return $sum;
         }
     }

    function updateAmount($productid, $aum, $userid)
    {
        
        $anzahl = getProduct($productid, $userid) + $aum;
        $sql = "UPDATE cart SET amount = $anzahl WHERE productid = $productid AND userid = $userid;";
        db_query($sql);
    }

   function countCartItemsWithoutAmount() {
    $userid = getCurrentUserId();
    $sql = "SELECT COUNT(amount) from cart where userid = $userid;";
     
     $cartResult = db_query($sql);

     $cartItems = mysqli_fetch_column($cartResult);

     return $cartItems;
   }

    function getDeliveryPrice()
    {
        $userid = getCurrentUserId();
        $sql = "SELECT sum(lieferkosten) FROM produkte, cart WHERE cart.productid = produkte.artnr AND userid = $userid;";
        $result = db_query($sql);
        $preis = mysqli_fetch_column($result);
        if($preis == 0) {
            $preis = 0;
        }
        return $preis;
    }

    function getTotalPrice()
    {
        $userid = getCurrentUserId();
        $itemprice = preg_replace('/[\@\;\" "]+/', '', getCartPrice($userid));
        
        $delprice = (double) getDeliveryPrice();
        
        $totalprice = $delprice + $itemprice;
        
        return $totalprice;
    }