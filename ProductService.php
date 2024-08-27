<?php

//interface yaratamiz
interface ProductInterface {

    //metodlar
    public function index();
    public function show($id);
    public function create($name, $price);
    public function update($id, $name, $price);
    public function delete($id);
}

//ProductService degan class yaratamiz u ProductInterface dan implementatsiya qiladi
class ProductService implements ProductInterface {
    //index metodi getProduct()metodidan olib barcha productlarni var_dump qiladi
    public function index() {
        var_dump($this->getProducts());
    }

    //show metodi $id parametrini qabul qiladi va kiritilgan id bo'yicha productni topib var_dump qiladi
    public function show($id)
    {
        $products = json_decode(file_get_contents('products.json'), true);

        if (is_array($products)) {
            foreach ($products as $product) {
                if (isset($product['id']) && $product['id'] === $id) {
                    var_dump($product);
                }
            }
        }

        return null;
    }

    //create metodi $name , $price paramlarni qabul qilib json faylga yozadi
    public function create($name, $price) {
        $products = json_decode(file_get_contents('products.json'), true);
    
        $newProduct = [
            "id" => uniqid(),// id yaratadi
            "name" => $name,
            "price" => $price
        ];
        $products[] = $newProduct; 
        file_put_contents('products.json', json_encode($products, JSON_PRETTY_PRINT));
    }

    public function update($id, $newName, $newPrice) {

        //json formatdan arrayga otkzamiz
        $products = json_decode(file_get_contents('products.json'), true);
        $productFound = false;

        //array boylab sikl aylantiramiz
        foreach ($products as $key=>$product) {

            //product idsi bor bo'lsa va u parametrdan kelayotgan idga teng bo'lsa yangilaymiz
            if (isset($product['id']) && $product['id'] === $id) {
                $products[$key]['id'] = $id;
                $products[$key]['name'] = $newName;
                $products[$key]['price'] = $newPrice;
                $productFound = true;
                break;
            }
        }
        //id topilmasa mahsulot topilmadi degan xabar chiqariladi
        if (!$productFound) {
            echo "Product not found.";
        }
        //yangilangan massivi yana json faylga yozamiz
        file_put_contents('products.json', json_encode($products, JSON_PRETTY_PRINT));    }

        public function delete($id) {
            $products = json_decode(file_get_contents('products.json'), true);
            $productFound = false;
        
            foreach ($products as $key => $product) {
                //product idsi bor bo'lsa va u parametrdan kelayotgan idga teng bo'lsa o'chiramiz
                if (isset($product['id']) && $product['id'] == $id) {
                    unset($products[$key]); 
                    $productFound = true;
                    break;
                }
            }
            //paramdan kelayotgan id dagi mahsulot topilmasa ↓ xabari chop etamiz
            if (!$productFound) {
                echo 'Product not found';
                return;
            }
            //yana json fayliga saqlimz
            file_put_contents('products.json', json_encode($products, JSON_PRETTY_PRINT));
        }

        // getProducts metodi json_decode qiladi va arrayni qaytaradi
        public function getProducts()
        {
            $products = json_decode(file_get_contents('products.json'), true);
            return $products;
        }
}

//Obyekt olamiz i metodlani chaqiramiz
$productService1 = new ProductService();
// $productService1->create("Olma", 100000);
// $productService1->update('66b1c4cb4f042', 'Olma yangilandi', 110000);
// $productService1->delete('66b1c4cb4f042');

$productService2 = new ProductService();
// $productService2->create("Nok", 200000);
// $productService2->update('66b1c4cb4f104', 'Nok yangilandi', 220000);
// $productService2->delete('66b1c4cb4f104');


$productService3 = new ProductService();
// $productService3->create("Qovun", 300000);
// $productService3->update('66b1c4cb4f3a0', 'Qovun yangilandi', 330000);
// $productService3->delete('66b1c4cb4f3a0');
// $productService3->show('66b1c4cb4f042');
// $productService3->index();

?>