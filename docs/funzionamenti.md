


*__Volontari__*

**Ordinamenti e Ricerca**


__gli ordinamenti__ avvengono richiamando la pagina index (list delle risorse) con i parametri "order" e "order_by", es:

> admin/volontari?order_by=registro&order=asc

nel Controller VolontariController@index vengono verificati questi parametri (per sovrascrivere eventuale default) ed utilizzati nella query di selezione. Siccome i volontari si possono ordinare anche per associazione, la query per trovare i volontari ha un left join con le associazioni 


__la ricerca__ avviene __sfruttando la tabella di appoggio tblQueryString__ :

il form richiama in POST VolontariController@search dove i parametri sono memorizzati come query string nel DB associandoli ad un $query_id numerico

> 3 | ricerca_campo=nome&q=Andrea

successivamente si fa un redirect alla index passando $query_id come url parameter

> return redirect("admin/volontari/$query_id");

infatti la route della risorsa viene sovrascritta per accettare questo eventuale parametro

>  Route::get('admin/volontari/{query_id?}', ['uses' => 'Admin\VolontariController@index', 'as' => 'volontari.index']);

nel Controller VolontariController@index viene verificato il parametro query_id e se è presente si prendono i paramentri nel DB e si __aggiungono ai paramentri in request__ 

quindi si verificano i parametri "ricerca_campo" e "q" ed eventualmente si filtra la query sui volontari





*__Preventivi__*

Siccome i preventivi si possono ordinare anche per associazione, la query per trovare i preventivi ha un left join con le associazioni 




*__Preventivi__ Global Scope "PreventiviOwnedByScope"*

L'elenco dei preventivi deve essere filtrato se sono un'associazione: se sono admin li vedo tutti, se sono associazione vedo solo "i miei". Si utilizza un GlobalScope sulla model Preventivo in modo che i preventivi VENGONO SEMPRE E COMUNQUE FILTRATI IN AUTOMATICO (se sono associazione) 


class PreventiviOwnedByScope implements Scope
.....
if(Auth::user()->hasRole('associazione'))
  {
  $builder->where('associazione_id', '=', Auth::user()->associazione->id);  
  }


class Preventivo extends Model
.....
protected static function boot()
	{
	    parent::boot();

	    static::addGlobalScope(new PreventiviOwnedByScope);
	}





*Creazione PDF*


https://github.com/barryvdh/laravel-dompdf

After updating composer, add the ServiceProvider to the providers array in config/app.php

> Barryvdh\DomPDF\ServiceProvider::class,

You can optionally use the facade for shorter code. Add this to your facades:

> 'PDF' => Barryvdh\DomPDF\Facade::class,


Use php artisan vendor:publish to create a config file located at config/dompdf.php which will allow you to define local configurations to change some settings (default paper etc). You can also use your ConfigProvider to set certain keys.

Configuration
The defaults configuration settings are set in config/dompdf.php. Copy this file to your own config directory to modify the values. You can publish the config using this command:

> php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"

You can still alter the dompdf options in your code before generating the pdf using this command:
> PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);





*CKEditor5*

Bisogna installare il plugin per upload delle immagini ed i plugin sono distribuiti come pacchetti npm:

Therefore, assuming that you want to customize the classic editor build you need to:

Clone the build repository.
Install the plugin package.
Add it to the build configuration.
Bundle the build.


>git clone -b stable https://github.com/ckeditor/ckeditor5-build-classic.git

>cd ckeditor5-build-classic

>npm install

Now, install the plugin package:

>npm install --save @ckeditor/ckeditor5-image


Edit the build-config.js file to add your plugin to the list of plugins which will be included in the build and to add your feature’s button to the toolbar:

Finally, bundle the build:

> npm run build


Poi devo installare il plugin EasyImage

To make the above process possible, an image upload plugin (such as EasyImage) must be available. Such plugin will handle both the upload and URL returning steps in the above workflow.

> npm install --save @ckeditor/ckeditor5-easy-image

e ancora per il build 

> npm run build