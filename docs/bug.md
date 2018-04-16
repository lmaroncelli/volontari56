
1. la Relazione non ha il create() ma il creaDaPreventivo() [la relazione si crea solo dal preventivo e non in modo autonomo] 


2. ::withTrashed() nelle model Preventivo e Relazione nel global scope in modo che prenda anche quelle cancellate logicamente e poi nel loop faccio un check sul campo deleted_at per vedere se sono cancellate logicamente (oppure di default le escludo e poi le metto come filtro per inserirle ??)

