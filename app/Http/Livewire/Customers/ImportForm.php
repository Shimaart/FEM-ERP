<?php

namespace App\Http\Livewire\Customers;

use App\Concerns\HasContacts;
use App\Http\Livewire\Contacts\ManagesContacts;
use App\Models\Contact;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportForm extends Component
{
    use WithFileUploads;

    public $file;

    public function rules(): array
    {
        return [
            'file' => ['required', 'file']
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $path = $this->file->getRealPath();
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadSheet = $reader->load($path); //Load the excel form

        foreach ($spreadSheet->getWorksheetIterator() as $worksheet) {
            $i = 0;
            $q_arr = [];
            foreach($worksheet->getRowIterator() as $row){
                $i++;
                if($i == 1){
                    continue;
                }
                $arr = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $j = 0;
                foreach($cellIterator as $cell) {
                    $j++;
                    $value = trim($cell->getValue());

                    if($j == 5) {
                        break;
                    } else {
                        $arr[$j] = $value;
                    }
                }

                if(count($arr)) {
                    $clients[] = $arr;
                }
            }
        }

        foreach ($clients as $key =>  $client) {
            try {
                if ($client && $client[1]) {
                    $customer = Customer::query()->firstOrCreate([
                        'name' => $client[1]
                    ]);

                    if ($client[2]) {
                        $customer->contacts()->firstOrCreate([
                            'type' => Contact::TYPE_PHONE_NUMBER,
                            'value' => '380'.$client[2]
                        ]);
                    }

                    if ($client[3]) {
                        $customer->contacts()->firstOrCreate([
                            'type' => Contact::TYPE_PHONE_NUMBER,
                            'value' => '380'.$client[3]
                        ]);
                    }

                    if ($client[4]) {
                        $customer->contacts()->firstOrCreate([
                            'type' => Contact::TYPE_PHONE_NUMBER,
                            'value' => '380'.$client[4]
                        ]);
                    }
                }
            } catch (\Exception $e) {
                dd($key, $e->getMessage());
            }

        }

        $this->emit('customersImpoted');
    }

    /**
     * @return HasContacts
     */
    protected function contactable()
    {
        return $this->customer;
    }
}
