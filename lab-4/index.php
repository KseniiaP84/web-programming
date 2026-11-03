<?php
declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use App\Core\Database;
use App\Services\EntityFactory;
use App\Services\EntityService;
use App\Services\ConsoleLogger;
use App\Services\FileLogger;
use App\Models\Store;
use App\Tasks\Worker;
use App\Tasks\WorkshopManager;
use App\Tasks\DepartmentHead;
use App\Tasks\EnterpriseManager;
use App\Tasks\Triangle;

require_once __DIR__ . '/../vendor/autoload.php';

$product = new Product(
    1,
    '2026-11-02',
    'Ноутбук',
    25000.0
);

echo PHP_EOL . "JSON-експорт товару:" . PHP_EOL;
echo $product->exportToJson() . PHP_EOL;

$user = new User(
    2,
    '2026-11-02',
    'Оксана',
    'oksana@example.com'
);

$database1 = Database::getInstance();
$database2 = Database::getInstance();

var_dump($database1 === $database2);

echo PHP_EOL . "Створення об'єктів через Factory:" . PHP_EOL;

$factoryProduct = EntityFactory::createEntity('product', [
    'id' => 3,
    'createdAt' => '2026-11-02',
    'name' => 'Мишка',
    'price' => 800.0
]);

$factoryUser = EntityFactory::createEntity('user', [
    'id' => 4,
    'createdAt' => '2026-11-02',
    'name' => 'Іван',
    'email' => 'ivan@example.com'
]);

echo $factoryProduct->getDetails() . PHP_EOL;
echo $factoryUser->getDetails() . PHP_EOL;

echo $product->getDetails() . PHP_EOL;
echo $user->getDetails() . PHP_EOL;

echo PHP_EOL . "Dependency Injection:" . PHP_EOL;

// Логування в консоль
$consoleLogger = new ConsoleLogger();
$entityService = new EntityService($consoleLogger);

$entityService->processEntity($product);

// Логування у файл
$fileLogger = new FileLogger();
$fileService = new EntityService($fileLogger);

$fileService->processEntity($user);

echo "Повідомлення записано у файл." . PHP_EOL;

echo PHP_EOL . "Робота з магазином:" . PHP_EOL;

$store = new Store(1, 'Tech Store');

$store->addProduct($product);
$store->addProduct($factoryProduct);

echo "Кількість товарів: " . count($store->getProducts()) . PHP_EOL;

$foundProduct = $store->searchProduct('Мишка');

if ($foundProduct !== null) {
    echo "Знайдено: " . $foundProduct->getDetails() . PHP_EOL;
}

$store->removeProduct(3);

echo "Кількість товарів після видалення: "
    . count($store->getProducts()) . PHP_EOL;

echo PHP_EOL . "Ієрархія працівників:" . PHP_EOL;

$workers = [
    new class('Петро', 20000) extends Worker {
    public function calculateSalary(): float
    {
        return $this->calculateBaseSalary();
    }
},
    new WorkshopManager('Іван', 20000),
    new DepartmentHead('Олена', 20000),
    new EnterpriseManager('Андрій', 20000)
];

foreach ($workers as $worker) {
    echo $worker->getName() . ': '
        . number_format($worker->calculateSalary(), 2, '.', '')
        . " грн" . PHP_EOL;
}

echo PHP_EOL . "Обчислення параметрів трикутника:" . PHP_EOL;

$triangle = new Triangle(3, 4, 5);

echo "Периметр: " . $triangle->calculatePerimeter() . PHP_EOL;
echo "Площа: " . $triangle->calculateArea() . PHP_EOL;