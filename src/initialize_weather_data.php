<?php

require_once __DIR__ . '/bootstrap.php';

try {
    $envImporter = new EnvImporter();
    $env = $envImporter->run();
    $dbh = new PDO("mysql:host=$env[hostname];dbname=$env[database]", $env['username'], $env['password']);
    createWeatherTable($dbh);
    importCsvData($dbh);
    setLocationInfo($dbh);
} catch (PDOException $e) {
    echo 'DB接続エラー：' . $e->getMessage() . PHP_EOL;
}

function createWeatherTable(PDO $dbh): void
{
    try {
        $dbh->query('DROP TABLE IF EXISTS weather');

        $createTableSql = <<<EOT
            CREATE TABLE IF NOT EXISTS weather (
                id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                date DATE NOT NULL,
                avg_temp FLOAT DEFAULT NULL,
                max_temp FLOAT DEFAULT NULL,
                min_temp FLOAT DEFAULT NULL,
                precipitation FLOAT DEFAULT NULL,
                sunlight_hours FLOAT DEFAULT NULL,
                avg_wind_speed FLOAT DEFAULT NULL,
                location INT NOT NULL
            ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4
        EOT;

        $dbh->query($createTableSql);
        echo 'DB作成を行いました。' . PHP_EOL;
    } catch (PDOException $e) {
        echo 'error: ' . $e->getMessage();
    }
}

function importCsvData(PDO $dbh): void
{
    try {
        $importSql = <<<EOT
            LOAD DATA INFILE '/var/lib/mysql-files/weather_data.csv'
            INTO TABLE weather
            FIELDS TERMINATED BY ',' ENCLOSED BY '"'
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES
            (@date, @avg_temp, @max_temp, @min_temp, @precipitation, @sunlight_hours, @avg_wind_speed, @location)
            SET
                date = STR_TO_DATE(@date, '%Y/%c/%e'),
                avg_temp = NULLIF(@avg_temp, ''),
                max_temp = NULLIF(@max_temp, ''),
                min_temp = NULLIF(@min_temp, ''),
                precipitation = NULLIF(@precipitation, ''),
                sunlight_hours = NULLIF(@sunlight_hours, ''),
                avg_wind_speed = NULLIF(@avg_wind_speed, ''),
                location = NULLIF(@location, '')
        EOT;

        $dbh->query($importSql);
        echo 'データのインポートが完了しました。' . PHP_EOL;
    } catch (PDOException $e) {
        echo 'error: ' . $e->getMessage();
    }
}

function setLocationInfo(PDO $dbh): void
{
    $dbh->query('DROP TABLE IF EXISTS location');

    $createLocationTableSql = <<<EOT
        CREATE TABLE IF NOT EXISTS location (
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            city_name VARCHAR(50) NOT NULL
        ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4
    EOT;

    $setLocationInfoSql = <<<EOT
        INSERT INTO location (city_name) VALUE ('札幌'), ('名古屋'), ('那覇')
    EOT;

    $dbh->query($createLocationTableSql);
    $dbh->query($setLocationInfoSql);

    echo '検索地点の登録が完了しました。' . PHP_EOL;
}
