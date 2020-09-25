<?php

namespace App\Http\Controllers\Api;

use App\Car;
use App\Http\Requests\CarCreateRequest;
use App\Http\Requests\CarSearchRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Repositories\CarRepository;
use App\Resources\CarResource;
use App\Services\CarService;
use Illuminate\Http\Request;

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

    public function __construct(CarRepository $carRepository, CarService $carService)
    {
        $this->carRepository = $carRepository;
        $this->carService = $carService;
    }


    public function index(Request $request)
    {
        try {

            $cars = $this->carRepository->getAllWithPaginate($request->all());

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

            $car = $this->carService->create($request);

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


}
