<?php
declare(strict_types=1);
use App\Services\DataProcessor;
use App\Services\EntityService;
use Faker\Factory;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/app/Models/EntityArray.php';
require_once __DIR__ . '/app/Services/EntityService.php';
require_once __DIR__ . '/app/Services/DataProcessor.php';

$faker = Factory::create();
$entityService = new EntityService();
$dataProcessor = new DataProcessor();

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Дані для підрахунку доступних місць.
$placesForCounting = [
    ['name' => 'Кафе Добре', 'is_accessible' => true],
    ['name' => 'Міська бібліотека', 'is_accessible' => true],
    ['name' => 'Стара аптека', 'is_accessible' => false],
];

$accessibleCount = $entityService->countAccessiblePlaces(
    $placesForCounting
);

// Faker: генеруємо 10 значень кількості відвідувачів.
$visitorCounts = [];

for ($i = 0; $i < 10; $i++) {
    $visitorCounts[] = $faker->numberBetween(100, 2000);
}

$minimumVisitors = 1000;

$popularPlaces = array_filter(
    $visitorCounts,
    function (int $visitors) use ($minimumVisitors): bool {
        return $visitors >= $minimumVisitors;
    }
);

// Розрахунок знижки та обробка винятку.
$discountedPrice = $entityService->applyDiscount(1000.0, 20.0);
$discountError = '';

try {
    $entityService->applyDiscount(1000.0, 150.0);
} catch (\Exception $exception) {
    $discountError = $exception->getMessage();
} finally {
    $discountCheckCompleted = true;
}

// Індивідуальні завдання, варіант 10.
$numbers = [2, 4, 6, 8];
$k = 10;
$allLessThan = $dataProcessor->areAllLessThan($numbers, $k);

$originalText = 'Доступність важлива для кожного';
$swappedText = $dataProcessor->swapFirstAndLastWord($originalText);

$textToShuffle = 'Кафе аптека бібліотека лікарня';
$shuffledText = $dataProcessor->shuffleWords($textToShuffle);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторна №3 — Доступ.City</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f7f4;
            color: #24352b;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            width: min(100% - 32px, 960px);
            margin: 0 auto;
            padding: 32px 0 48px;
        }

        header {
            padding: 28px;
            margin-bottom: 24px;
            background: #176b45;
            color: white;
            border-radius: 18px;
        }

        .brand {
            margin: 0 0 12px;
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        h1 {
            margin: 0 0 8px;
            font-size: clamp(26px, 5vw, 38px);
        }

        header p {
            margin: 8px 0 0;
            color: #e1eee5;
        }

        .section {
            padding: 24px;
            margin-bottom: 20px;
            background: white;
            border: 1px solid #e0e8e1;
            border-radius: 16px;
            box-shadow: 0 4px 14px rgb(25 65 40 / 4%);
        }

        h2 {
            margin: 0 0 16px;
            color: #176b45;
            font-size: 22px;
        }

        h3 {
            margin: 22px 0 8px;
            font-size: 17px;
        }

        .muted {
            color: #68766d;
        }

        .category-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 0;
            list-style: none;
        }

        .category-list li {
            padding: 8px 14px;
            background: #edf5ef;
            border-radius: 9px;
        }

        .place-card {
            padding: 18px;
            background: #f8fbf8;
            border: 1px solid #dce9de;
            border-radius: 12px;
        }

        .place-name {
            margin: 0;
            font-size: 20px;
        }

        .status {
            display: inline-block;
            padding: 4px 10px;
            color: #176b45;
            background: #e1f3e5;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 12px;
            margin-top: 16px;
        }

        .detail {
            padding: 12px;
            background: #f0f5f1;
            border-radius: 9px;
            overflow-wrap: anywhere;
        }

        .detail small {
            display: block;
            color: #68766d;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
        }

        .stat {
            padding: 16px;
            background: #edf5ef;
            border-radius: 12px;
        }

        .stat strong {
            display: block;
            color: #176b45;
            font-size: 28px;
        }

        .number-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
            gap: 8px;
            padding: 0;
            list-style: none;
        }

        .number-list li {
            padding: 10px;
            text-align: center;
            background: #f0f5f1;
            border-radius: 8px;
        }

        .number-list .popular {
            color: #176b45;
            background: #e1f3e5;
            font-weight: bold;
        }

        .result {
            padding: 14px;
            background: #f0f5f1;
            border-radius: 10px;
            overflow-wrap: anywhere;
        }

        .error {
            color: #a02e2e;
            background: #fff0ef;
        }

        .success {
            color: #176b45;
        }

        footer {
            padding-top: 8px;
            color: #68766d;
            text-align: center;
            font-size: 13px;
        }

        @media (max-width: 520px) {
            .container {
                width: min(100% - 20px, 960px);
                padding-top: 10px;
            }

            header,
            .section {
                padding: 18px;
                border-radius: 12px;
            }
        }
    </style>
</head>

<body>
<main class="container">

    <header>
        <p class="brand">Доступ.City</p>
        <h1>Лабораторна робота №3</h1>
        <p>Основи PHP: структури даних, функції та обробка винятків.</p>
        <p>Демонстрація роботи платформи пошуку доступних місць.</p>
    </header>

    <section class="section">
        <h2>01. Масиви та структури даних</h2>
        <p class="muted">
            Категорії відсортовані за алфавітом за допомогою sort().
        </p>

        <ul class="category-list">
            <?php foreach ($places as $item): ?>
                <li><?= escapeHtml($item) ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Інформація про місце</h3>

        <div class="place-card">
            <p class="place-name"><?= escapeHtml($place['name']) ?></p>
            <p class="muted"><?= escapeHtml($place['address']) ?></p>

            <span class="status">
                <?= $place['is_accessible'] ? 'Доступне місце' : 'Недоступне місце' ?>
            </span>

            <div class="details">
                <?php foreach ($place as $key => $value): ?>
                    <div class="detail">
                        <small><?= escapeHtml((string) $key) ?></small>
                        <strong>
                            <?= escapeHtml(
                                is_bool($value)
                                    ? ($value ? 'Так' : 'Ні')
                                    : (string) $value
                            ) ?>
                        </strong>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section">
        <h2>02. Робота з EntityService</h2>
        <div class="stats">
            <div class="stat">
                <strong><?= $accessibleCount ?></strong>
                доступних місць із <?= count($placesForCounting) ?>
            </div>
        </div>
        <p class="muted">
            Кількість обчислено функцією countAccessiblePlaces()
            на основі переданого масиву.
        </p>
    </section>

    <section class="section">
        <h2>03. Faker та анонімна функція</h2>
        <p class="muted">
            Випадкова кількість відвідувачів у десяти закладах за місяць.
            Зеленим виділено значення, що відповідають критерію.
        </p>

        <ul class="number-list">
            <?php foreach ($visitorCounts as $visitors): ?>
                <li class="<?= $visitors >= $minimumVisitors ? 'popular' : '' ?>">
                    <?= $visitors ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="result">
            <strong>Критерій:</strong>
            не менше <?= $minimumVisitors ?> відвідувачів.
            <br>
            <strong>Кількість значень, що відповідають критерію:</strong>
            <?= count($popularPlaces) ?>
        </div>

        <h3>Результат фільтрації</h3>

        <?php if ($popularPlaces !== []): ?>
            <ul>
                <?php foreach ($popularPlaces as $visitors): ?>
                    <li><?= $visitors ?> відвідувачів</li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Немає значень, які відповідають критерію.</p>
        <?php endif; ?>
    </section>

    <section class="section">
        <h2>04. Знижка та обробка винятків</h2>

        <div class="stats">
            <div class="stat">
                <strong>1000 грн</strong>
                Початкова ціна
            </div>
            <div class="stat">
                <strong>20%</strong>
                Коректна знижка
            </div>
            <div class="stat">
                <strong><?= number_format($discountedPrice, 2, '.', ' ') ?> грн</strong>
                Ціна після знижки
            </div>
        </div>

        <h3>Перевірка некоректної знижки</h3>
        <p class="result error">
            <strong>Перехоплений виняток:</strong>
            <?= escapeHtml($discountError) ?>
        </p>
        <p class="success">
            ✓ Перевірку знижки завершено.
        </p>
    </section>

    <section class="section">
        <h2>05. Індивідуальні завдання — варіант 10</h2>

        <h3>Завдання 1. Перевірка масиву</h3>
        <p>Масив: <?= escapeHtml(implode(', ', $numbers)) ?></p>
        <p>Число K: <?= $k ?></p>
        <p class="result">
            Усі елементи менші за K:
            <strong><?= $allLessThan ? 'true' : 'false' ?></strong>
        </p>

        <h3>Завдання 2. Обмін першого й останнього слова</h3>
        <p class="muted">Початковий рядок</p>
        <p><?= escapeHtml($originalText) ?></p>
        <p class="muted">Результат</p>
        <p class="result"><?= escapeHtml($swappedText) ?></p>

        <h3>Завдання 3. Випадкове перемішування слів</h3>
        <p class="muted">Початковий рядок</p>
        <p><?= escapeHtml($textToShuffle) ?></p>
        <p class="muted">Результат</p>
        <p class="result"><?= escapeHtml($shuffledText) ?></p>
    </section>

    <footer>
        Доступ.City · Лабораторна робота №3 · PHP
    </footer>

</main>
</body>
</html>