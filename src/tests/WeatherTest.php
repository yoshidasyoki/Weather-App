<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../core/DatabaseManager.php';
require_once __DIR__ . '/../core/DatabaseModel.php';
require_once __DIR__ . '/../exception/AttackDetectException.php';
require_once __DIR__ . '/../models/Weather.php';

class WeatherTest extends TestCase
{
    public function testGetDataSuccess(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);

        $location = 2;
        $start = '2025-09-30';
        $end = '2025-09-30';
        $searchLists = ['max_temp'];

        $result = $weather->getData($location, $start, $end, $searchLists);
        $answer = [['date' => '2025-09-30', 'max_temp' => 29.4]];
        $this->assertSame($result, $answer);
    }

    public function testGetDataFailureByWhiteCheck(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);

        $this->expectException(AttackDetectException::class);

        $location = 2;
        $start = '2025-09-30';
        $end = '2025-09-30';
        $searchLists = ['virus'];
        $weather->getData($location, $start, $end, $searchLists);
    }

    public function testGetDataFailureByNotMatched(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);

        $this->expectException(InvalidArgumentException::class);

        $location = 2;
        $start = '2099-01-01';
        $end = '2099-12-31';
        $searchLists = ['max_temp'];
        $weather->getData($location, $start, $end, $searchLists);
    }

    public function testGetSearchLists(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);

        $searchLists = $weather->getSearchLists();
        $answer = ['avg_temp', 'max_temp', 'min_temp', 'precipitation', 'sunlight_hours', 'avg_wind_speed', 'location'];
        $this->assertSame($searchLists, $answer);
    }

    public function testGetLatestDate(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);

        $latest = $weather->getLatestDate();
        $this->assertSame($latest, '2025-09-30');
    }

    public function testGetCityName(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);

        $cityName = $weather->getCityName(2);
        $this->assertSame($cityName, '名古屋');
    }
}
