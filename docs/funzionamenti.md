


*__Volontari__*

**Ordinamenti e Ricerca**


__gli ordinamenti__ avvengono richiamando la pagina index (list delle risorse) con i parametri "order" e "order_by", es:

> admin/volontari?order_by=registro&order=asc

nel Controller vengono verificati questi parametri (per sovrascrivere eventuale default) ed utilizzati nella query di selezione. Siccome i volontari si possono ordinare anche per associazione, la query per trovare i volontari ha un left join con le associazioni 



