


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

