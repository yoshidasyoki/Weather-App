<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../core/DatabaseManager.php';
require_once __DIR__ . '/../core/DatabaseModel.php';
require_once __DIR__ . '/../models/Weather.php';
require_once __DIR__ . '/../core/Service.php';
require_once __DIR__ . '/../exception/AttackDetectException.php';

class ServiceTest extends TestCase
{
    public function testInit(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);
        $service = new Service($weather);

        $answerInfo = ['cityName' => '名古屋', 'start' => '2025-09-01', 'end' => '2025-09-30'];
        $answerCount = 30;

        $result = $service->init();
        $info = $result['info'];
        $json = $result['json'];

        $this->assertSame($info, $answerInfo);
        $this->assertSame(count($json), $answerCount);
    }

    public function testSearchSuccess(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);
        $service = new Service($weather);

        $request = [
            'location' => 2,
            'start' => '2025-09-29',
            'end' => '2025-09-30',
            'searches' => ['max_temp', 'min_temp']
        ];
        $result = $service->search($request);

        $answer = [
            'info' => [
                'cityName' => '名古屋',
                'start' => '2025-09-29',
                'end' => '2025-09-30'
            ],
            'json' => [
                ['date' => '2025-09-29', 'max_temp' => 29.5, 'min_temp' => 21.7],
                ['date' => '2025-09-30', 'max_temp' => 29.4, 'min_temp' => 19.4]
            ]
        ];
        $this->assertSame($result, $answer);
    }

    public function testSearchFailureByReverseDate(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);
        $service = new Service($weather);

        $this->expectException(InvalidArgumentException::class);

        $request = [
            'location' => 2,
            'start' => '2025-09-01',
            'end' => '2025-80-01',
            'searches' => ['max_temp', 'min_temp']
        ];
        $service->search($request);
    }

    public function testSearchFailureByFraudDate(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);
        $service = new Service($weather);

        $this->expectException(InvalidArgumentException::class);

        $request = [
            'location' => 2,
            'start' => '2025-09-99',
            'end' => '2025-10-00',
            'searches' => ['max_temp', 'min_temp']
        ];
        $service->search($request);
    }

    public function testSearchFailureByBlankRequest(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);
        $service = new Service($weather);

        $this->expectException(InvalidArgumentException::class);

        $request = [
            'location' => 2,
            'start' => '2025-09-01',
            'end' => '2025-09-30',
            'searches' => []
        ];
        $service->search($request);
    }

    public function testSearchFailureByWhiteCheck(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);
        $service = new Service($weather);

        $this->expectException(AttackDetectException::class);

        $request = [
            'location' => 2,
            'start' => '2025-09-01',
            'end' => '2025-09-30',
            'searches' => ['script']
        ];
        $service->search($request);
    }

    public function testSearchFailureByNotMatched(): void
    {
        $dbh = new PDO("mysql:host=db;dbname=test_database", 'test_user', 'pass');
        $weather = new Weather($dbh);
        $service = new Service($weather);

        $this->expectException(InvalidArgumentException::class);

        $request = [
            'location' => 2,
            'start' => '2099-09-01',
            'end' => '2099-09-30',
            'searches' => ['max_temp']
        ];
        $service->search($request);
    }
}
