<?php 

namespace App\Exports;
use App\Associazione;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;


/**
 * The easiest way to start an export is to create a custom export class
 */

//class exportOreServizio implements FromCollection
class exportOreServizio implements FromView
{


		/**
		 * [__construct description]
		 * @param array $data [description]
	   *
	   * dd($volontari);
	   * 
	   * array:17 [▼
	      1274 => array:3 [▼
	        "Associazione" => "A.N.P.A.N.A."
	        "Volontario" => "Barbino Massimo"
	        "Totale ore" => 7
	      ]
	      1275 => array:3 [▼
	        "Associazione" => "A.N.P.A.N.A."
	        "Volontario" => "Bedetti Letizia"
	        "Totale ore" => 0
	      ]
	      1276 => array:3 [▼
	        "Associazione" => "A.N.P.A.N.A."
	        "Volontario" => "Bedetti Romina"
	        "Totale ore" => 0
	      ]
	   * 
		 */
		
		public function __construct($volontari = [])
			{
				 $this->volontari = $volontari;
			}


    /*public function collection()
    {
        return Associazione::pluck('nome');
    }*/

    public function view(): View
      {
          return view('admin.relazioni.excel_ore', [
              'volontari' => $this->volontari
          ]);
      }



}