<?php

class Service
{
    public function __construct(private Weather $weatherModel) {}

    public function init(): array
    {
        $location = 2;
        $defaultDate = $this->getDefaultDate();
        $start = $defaultDate['start'];
        $end = $defaultDate['end'];
        $searches = $this->weatherModel->getSearchLists();

        return $this->handle($location, $start, $end, $searches);
    }

    public function search(array $requestData): array
    {
        $location = $requestData['location'] ?? null;
        $start = $this->validateDate($requestData['start']);
        $end = $this->validateDate($requestData['end']);
        $searches = $requestData['searches'] ?? null;

        return $this->handle($location, $start, $end, $searches);
    }

    private function handle(int $location, string $start, string $end, array $searches): array
    {
        if ($start > $end) {
            throw new InvalidArgumentException();
        }

        if ($this->isEmpty($location, $start, $end, $searches)) {
            throw new InvalidArgumentException();
        }

        $responseData = $this->weatherModel->getData($location, $start, $end, $searches);
        $cityName = $this->weatherModel->getCityName($location);

        return [
            'info' => ['cityName' => $cityName, 'start' => $start, 'end' => $end],
            'json' => $responseData
        ];
    }

    private function getDefaultDate(): array
    {
        $end = $this->weatherModel->getLatestDate();
        $start = substr($end, 0, -3) . '-01';
        return [
            'start' => $start,
            'end' => $end
        ];
    }

    private function validateDate(string $date): string
    {
        $check = str_replace('-', '', $date);
        $year = (int) substr($check, 0, 4);
        $month = (int) substr($check, 4, -2);
        $day = (int) substr($check, 6, 7);

        if (!checkdate($month, $day, $year)) {
            throw new InvalidArgumentException();
        }
        return $date;
    }

    private function isEmpty(int|string|array ...$params): bool
    {
        foreach ($params as $param) {
            if (empty($param)) {
                return true;
            }
        }
        return false;
    }
}
