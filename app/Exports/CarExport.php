<?php

namespace App\Exports;

use App\Repositories\CarRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class CarExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    private $countRowIntoData = [];
    /**
     * @var CarRepository
     */
    private $carRepository;
    /**
     * @var Request
     */
    private $request;

    public function __construct(CarRepository $carRepository, Request $request)
    {
        $this->carRepository = $carRepository;
        $this->request = $request;
    }

    /**
     * @throws \Exception
     */
    public function collection()
    {
        return $this->carRepository->getAll($this->request, false);
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($car): array
    {
        return [
            $car->id,
            $car->name,
            $car->color,
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'id','name','color'
        ];
    }
}

