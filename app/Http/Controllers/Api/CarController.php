<?php

namespace App\Http\Controllers\Api;

use App\Car;
use App\Exports\CarExport;
use App\Http\Requests\CarCreateRequest;
use App\Http\Requests\CarSearchRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Http\Requests\ManufactureSearchRequest;
use App\Repositories\CarRepository;
use App\Repositories\ManufactureRepository;
use App\Resources\CarResource;
use App\Resources\ManufactureResource;
use App\Services\CarService;
use App\Services\VpicRequestService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CarController extends ApiController
{
    /**
     * @var CarRepository
     */
    private $carRepository;
    /**
     * @var CarService
     */
    private $carService;
    /**
     * @var VpicRequestService
     */
    private $vpicRequestService;
    /**
     * @var ManufactureRepository
     */
    private $manufactureRepository;

    public function __construct(
        CarRepository $carRepository,
        CarService $carService,
        VpicRequestService $vpicRequestService,
        ManufactureRepository $manufactureRepository
    )
    {
        $this->carRepository = $carRepository;
        $this->carService = $carService;
        $this->vpicRequestService = $vpicRequestService;
        $this->manufactureRepository = $manufactureRepository;
    }


    public function index(Request $request)
    {
        try {

            $cars = $this->carRepository->getAll($request->all());

            return CarResource::collection($cars);
        } catch (\Exception $error){
            return $this->errorJsonMessage($error->getMessage());
        }
    }

    public function show(Car $car)
    {
        try {

            return CarResource::make($car);
        } catch (\Exception $error){
            return $this->errorJsonMessage($error->getMessage());
        }
    }

    public function create(CarCreateRequest $request)
    {
        try {

            $decodeData = $this->prettyData($this->vpicRequestService->decodeVinCode($request->input('vin_code')));

            $car = $this->carService->create($request, $decodeData);

            return CarResource::make($car);
        } catch (\Exception $error){
            return $this->errorJsonMessage($error->getMessage());
        }
    }

    public function update(CarUpdateRequest $request, Car $car)
    {
        try {

            $car = $this->carService->update($request, $car);

            return CarResource::make($car);
        } catch (\Exception $error){
            return $this->errorJsonMessage($error->getMessage());
        }
    }

    public function remove(Car $car)
    {
        try {

            $this->carService->remove($car);

            return $this->successJsonMessage('Модель удалена');
        } catch (\Exception $error){
            return $this->errorJsonMessage($error->getMessage());
        }
    }

    public function search(CarSearchRequest $request)
    {
        try {

            $cars = $this->carRepository->search($request->input('query'));

            return CarResource::collection($cars);
        } catch (\Exception $error){
            return $this->errorJsonMessage($error->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        try {

            return Excel::download(new CarExport($this->carRepository, $request), 'cars.xlsx');

        } catch (\Exception $error){
            return $this->errorJsonMessage($error->getMessage());
        }
    }

    public function autoComlite(ManufactureSearchRequest $request)
    {
        try {

            $manufactures = $this->manufactureRepository->search($request->input('query'));

            return ManufactureResource::collection($manufactures);

        } catch (\Exception $error){
            return $this->errorJsonMessage($error->getMessage());
        }
    }

    private function prettyData($data)
    {
        $mid = [];

        if(isset($data['Results']) && !empty($data['Results'])){
            foreach ($data['Results'] as $item){
                if($item['Variable'] == 'Make'){
                    $mid['manufacture_id'] = $item['ValueId'];
                }
                if($item['Variable'] == 'Model'){
                    $mid['model_id'] = $item['ValueId'];
                }
                if($item['Variable'] == 'Model Year'){
                    $mid['year'] = $item['Value'];
                }
            }
        }

        if(empty($mid) && count($mid) != 3){
            throw new \Exception('Нет нужных данных при декодировани');
        }

        return $mid;
    }


}
