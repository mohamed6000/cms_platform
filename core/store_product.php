<?php

class StoreCategory {
    public function __construct($database) {
        $this->conn = $database->get_connection();
    }

    public function create($name) {
        if (isset($this->conn)) {
            $name = htmlspecialchars(strip_tags($name));
            try {
                $sql = "insert into `store_product_category` (name) values (:name)";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["name" => $name]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_all() {
        if (isset($this->conn)) {
            try {
                $sql = "select * from `store_product_category`";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetchAll();
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update($name, $id) {
        if (isset($this->conn)) {
            $name = htmlspecialchars(strip_tags($name));
            $id = htmlspecialchars(strip_tags($id));
            try {
                $sql = "update `store_product_category` set name = :name where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["name" => $name, "id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function delete($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            try {
                $sql = "delete from `store_product_category` where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }
};

class StoreProduct {
    public function __construct($database) {
        $this->conn = $database->get_connection();
    }

    public function create($title, $brand,
                           $original_price, $new_price,
                           $description, $specification,
                           $stock, 
                           $image0, $image1, $image2, $image3, 
                           $category, $creator) {
        if (isset($this->conn)) {
            $title = htmlspecialchars(strip_tags($title));
            $brand = htmlspecialchars(strip_tags($brand));
            $original_price = htmlspecialchars(strip_tags($original_price));
            $new_price = htmlspecialchars(strip_tags($new_price));
            $description = htmlspecialchars(strip_tags($description));
            $specification = htmlspecialchars(strip_tags($specification));
            $stock = htmlspecialchars(strip_tags($stock));
            $image0 = htmlspecialchars(strip_tags($image0));
            $image1 = htmlspecialchars(strip_tags($image1));
            $image2 = htmlspecialchars(strip_tags($image2));
            $image3 = htmlspecialchars(strip_tags($image3));
            $category = htmlspecialchars(strip_tags($category));
            $creator = htmlspecialchars(strip_tags($creator));

            try {
                $sql = "insert into `store_product` (title, brand, original_price, new_price, description, specification, stock, image0, image1, image2, image3, category, creator) 
                                             values ('$title', '$brand', '$original_price', '$new_price', '$description', '$specification', '$stock', 
                                             '$image0','$image1','$image2','$image3', '$category', '$creator')";
                $this->conn->exec($sql);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return "Problème interne, réessayez plus tard ou contactez l'assistance.";
    }

    public function get_all($category = false, $min_price = false, $max_price = false, $page = 1, $per_page = 10) {
        if (isset($this->conn)) {
            $category = htmlspecialchars(strip_tags($category));
            $min_price = htmlspecialchars(strip_tags($min_price));
            $max_price = htmlspecialchars(strip_tags($max_price));
            $page = htmlspecialchars(strip_tags($page));
            $per_page = htmlspecialchars(strip_tags($per_page));

            try {
                $sql = "select count(*) as product_count from `store_product`";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();
                $product_count = (int)$result["product_count"];

                $pages = ceil($product_count / $per_page);

                $first = ($page * $per_page) - $per_page;

                if ($category) {
                    if (!$min_price || !$max_price) {
                        $sql = "select store_product.id, title, brand, original_price, new_price, description, specification,
                        stock, image0, image1, image2, image3, date_created, creator, name from store_product, store_product_category 
                        where name = '$category' and 
                        store_product.category = store_product_category.id
                        limit $first, $per_page";
                    } else {
                        $sql = "select store_product.id, title, brand, original_price, new_price, description, specification,
                        stock, image0, image1, image2, image3, date_created, creator, name from store_product, store_product_category 
                        where ((original_price >= $min_price and original_price <= $max_price) or
                        (new_price >= $min_price and new_price <= $max_price)) and
                        (name = '$category' and 
                        store_product.category = store_product_category.id)
                        limit $first, $per_page";
                    }
                } else {
                    if (!$min_price || !$max_price) {
                        $sql = "select distinct * from `store_product` limit $first, $per_page";
                    } else {
                        $sql = "select distinct * from `store_product` where 
                        ((original_price >= $min_price and original_price <= $max_price) or
                        (new_price >= $min_price and new_price <= $max_price))
                        limit $first, $per_page";
                    }
                }
                $stmt = $this->conn->query($sql);
                $products = $stmt->fetchAll();
                return ["products" => $products, "pages" => $pages];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_latest($product_count = 10) {
        if (isset($this->conn)) {
            $product_count = htmlspecialchars(strip_tags($product_count));

            try {
                $sql = "select * from `store_product` order by date_created desc limit $product_count";
                $stmt = $this->conn->query($sql);
                $products = $stmt->fetchAll();
                return $products;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_featured($product_count = 10) {
        if (isset($this->conn)) {
            $product_count = htmlspecialchars(strip_tags($product_count));

            try {
                $sql = "select * from `store_product` where new_price > 0 order by date_created desc limit $product_count";
                $stmt = $this->conn->query($sql);
                $products = $stmt->fetchAll();
                return $products;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_single($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "select * from store_product where id = :id";
                $stmt = $this->conn->prepare($sql);
                if ($stmt->execute(["id" => $id])) {
                    $product = $stmt->fetch();
                    return $product;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_single_display($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "select store_product.id, title, brand, original_price, new_price, description,
                        specification, stock, image0, image1, image2, image3, date_created,
                        creator, name as category
                        from store_product, store_product_category 
                        where store_product.category = store_product_category.id and
                        store_product.id = :id";
                $stmt = $this->conn->prepare($sql);
                if ($stmt->execute(["id" => $id])) {
                    $product = $stmt->fetch();
                    return $product;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_related($id, $title, $brand, $category) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $title = htmlspecialchars(strip_tags($title));
            $brand = htmlspecialchars(strip_tags($brand));
            $category = htmlspecialchars(strip_tags($category));

            try {
                $sql = "select id, title, brand, new_price as price, date_created, stock, image1 as picture from store_product where id not in (select id from store_product where id = $id) and 
                        (title like '%$title%' or title like '%$brand%' or title like '%$category%' or
                        brand like '%$title%' or brand like '%$brand%' or brand like '%$category%')";
                $stmt = $this->conn->query($sql);
                $product = $stmt->fetchAll();
                return $product;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update($title, $brand,
                           $original_price, $new_price,
                           $description, $specification,
                           $stock, 
                           $image0, $image1, $image2, $image3, 
                           $category, $id) {
        if (isset($this->conn)) {
            $title = htmlspecialchars(strip_tags($title));
            $brand = htmlspecialchars(strip_tags($brand));
            $original_price = htmlspecialchars(strip_tags($original_price));
            $new_price = htmlspecialchars(strip_tags($new_price));
            $description = htmlspecialchars(strip_tags($description));
            $specification = htmlspecialchars(strip_tags($specification));
            $stock = htmlspecialchars(strip_tags($stock));
            $image0 = htmlspecialchars(strip_tags($image0));
            $image1 = htmlspecialchars(strip_tags($image1));
            $image2 = htmlspecialchars(strip_tags($image2));
            $image3 = htmlspecialchars(strip_tags($image3));
            $category = htmlspecialchars(strip_tags($category));
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `store_product` set title = :title, brand = :brand, 
                                                   original_price = :original_price, 
                                                   new_price = :new_price, 
                                                   description = :description, 
                                                   specification = :specification, stock = :stock, 
                                                   image0 = :image0, image1 = :image1, 
                                                   image2 = :image2, image3 = :image3, category = :category
                                                   where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["title" => $title, 
                                          "brand" => $brand,
                                          "original_price" => $original_price,
                                          "new_price" => $new_price,
                                          "description" => $description,
                                          "specification" => $specification,
                                          "stock" => $stock,
                                          "image0" => $image0,
                                          "image1" => $image1,
                                          "image2" => $image2,
                                          "image3" => $image3,
                                          "category" => $category,
                                          "id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function delete($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "delete from `store_product` where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }
};

class StoreBasket {
    public function __construct($database) {
        $this->conn = $database->get_connection();
    }

    public function create($product, $client, $quantity) {
        if (isset($this->conn)) {
            $product = htmlspecialchars(strip_tags($product));
            $client = htmlspecialchars(strip_tags($client));
            $quantity = htmlspecialchars(strip_tags($quantity));

            try {
                $sql = "insert into `store_basket` (product, client, quantity) values (:product, :client, :quantity)";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute([
                    "product" => $product,
                    "client" => $client,
                    "quantity" => $quantity
                ]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_count_by_client($client) {
        if (isset($this->conn)) {
            $client = htmlspecialchars(strip_tags($client));

            try {
                $sql = "select count(store_product.id) as total, store_product.id from store_product, store_basket where store_product.id = store_basket.product and client = $client";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetch();
                return $result["total"];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_products_by_client($client) {
        if (isset($this->conn)) {
            $client = htmlspecialchars(strip_tags($client));

            try {
                $sql = "select store_product.id, store_basket.id as bid, title, original_price, new_price, store_basket.quantity as quantity from store_product, store_basket where store_product.id = store_basket.product and client = $client";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetchAll();
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function delete_one_from_client_by_id($id, $client) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $client = htmlspecialchars(strip_tags($client));

            try {
                $sql = "delete from store_basket where id = :id and client = :client";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute([
                    "id" => $id,
                    "client" => $client
                ]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }
};

class Order {
    public function __construct($database) {
        $this->conn = $database->get_connection();
    }

    public function add($first_name, $last_name, $address, $phone, $email, $pay, $client_id) {
        if (isset($this->conn)) {
            $first_name = htmlspecialchars(strip_tags($first_name));
            $last_name = htmlspecialchars(strip_tags($last_name));
            $address = htmlspecialchars(strip_tags($address));
            $phone = htmlspecialchars(strip_tags($phone));
            $email = htmlspecialchars(strip_tags($email));
            $pay = htmlspecialchars(strip_tags($pay));
            $client_id = htmlspecialchars(strip_tags($client_id));

            try {
                $total = 0;
                $content = "";
                {
                    $sql = "select store_product.id, store_basket.id as bid, title, original_price, new_price, store_basket.quantity as quantity from store_product, store_basket where store_product.id = store_basket.product and client = $client_id";
                    $stmt = $this->conn->query($sql);
                    $products = $stmt->fetchAll();

                    foreach ($products as $i => $p) {
                        $the_price = ($p["new_price"] > 0) ? $p["new_price"] : $p["original_price"];
                        $q = (int)$p["quantity"];
                        $total += $the_price * $q;

                        if ($q > 1) {
                            $content .= '<li>'. ($i + 1) .'. '. $p["title"] .' <span>'. $q . " x " . $the_price .' DT</span></li>';
                        } else {
                            $content .= '<li>'. ($i + 1) .'. '. $p["title"] .' <span>'. $the_price .' DT</span></li>';
                        }

                        $query = "update store_product set stock = stock - " . $q . " where id = " . $p["id"];
                        $stmt = $this->conn->prepare($query);
                        $result = $stmt->execute();
                    }
                }

                $sql = "insert into `store_order` (first_name, last_name, address, phone, email, pay, content, total, client_id) values (:first_name, :last_name, :address, :phone, :email, :pay, :content, :total, :client_id)";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute([
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "address" => $address,
                    "phone" => $phone,
                    "email" => $email,
                    "pay" => $pay,
                    "content" => $content,
                    "total" => $total,
                    "client_id" => $client_id,
                ]);

                if ($result) {
                    $sql = "delete from store_basket where client = :client";
                    $stmt = $this->conn->prepare($sql);
                    $result = $stmt->execute([
                        "client" => $client_id
                    ]);
                    return $result;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_orders_by_client($client) {
        if (isset($this->conn)) {
            $client = htmlspecialchars(strip_tags($client));

            try {
                $sql = "select * from store_order where client_id = $client";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetchAll();
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_order_by_id_for_client($id, $client) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $client = htmlspecialchars(strip_tags($client));

            try {
                $sql = "select * from store_order where id = $id and client_id = $client limit 1";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetch();
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_order_by_id($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "select * from store_order where id = $id limit 1";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetch();
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_all($page = 1, $per_page = 10) {
        if (isset($this->conn)) {
            $page = htmlspecialchars(strip_tags($page));
            $per_page = htmlspecialchars(strip_tags($per_page));

            try {
                $sql = "select count(*) as bill_count from `store_order`";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();
                $product_count = (int)$result["bill_count"];

                $pages = ceil($product_count / $per_page);

                $first = ($page * $per_page) - $per_page;

                $sql = "select * from `store_order` limit $first, $per_page";
                $stmt = $this->conn->query($sql);
                $products = $stmt->fetchAll();
                return ["bills" => $products, "pages" => $pages];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }
};

?>