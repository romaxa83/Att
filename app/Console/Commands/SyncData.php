<?php

namespace App\Console\Commands;

use App\Manufacture;
use App\Model;
use App\Services\VpicRequestService;
use Illuminate\Console\Command;

class SyncData extends Command
{
    protected $signature = 'sync:data';

    protected $description = 'Синхронизация данных';
    /**
     * @var VpicRequestService
     */
    private $vpicRequestService;

    public function __construct(VpicRequestService $vpicRequestService)
    {
        parent::__construct();

        $this->vpicRequestService = $vpicRequestService;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
//        $this->sync();
        $this->syncManufactures();
    }

    /**
     * @throws \Exception
     */
    private function sync()
    {
        $models = $this->vpicRequestService->getManufactures();
        $makeId = $models['Results']['0']['Make_ID'];
//dd($makeId);
//dd($models['Results']['500']);
        $m = $this->vpicRequestService->getModels($makeId);
        dd($m, $models['Results']['0']);

    }

    private function syncManufactures()
    {
        $manufactures = $this->vpicRequestService->getManufactures();

        foreach(array_chunk($manufactures['Results'], 500) as $chunk){

            $data = [];
            foreach ($chunk as $key => $manufacture){
                $data[$key]['make_id'] = $manufacture['Make_ID'];
                $data[$key]['name'] = $manufacture['Make_Name'];

                // model
                $models =  $this->vpicRequestService->getModels($manufacture['Make_ID']);

                foreach (array_chunk($models['Results'], 500) as $chunkModel){
                    $dataModel = [];
                    foreach ($chunkModel as $k => $model){
                        $dataModel[$k]['make_id'] = $model['Make_ID'];
                        $dataModel[$k]['model_id'] = $model['Model_ID'];
                        $dataModel[$k]['name'] = $model['Model_Name'];
                    }
                    array_values($dataModel);

                    $colModel = [
                        'make_id', 'model_id', 'name'
                    ];

                    Model::insertOnDuplicateKey($dataModel, $colModel);
                }


            }
            array_values($data);

            $columns = [
                'make_id', 'name'
            ];

            $result = Manufacture::insertOnDuplicateKey($data, $columns);

        }

    }

}
