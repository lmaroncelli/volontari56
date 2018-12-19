


SELECT v.* , u.login_utenti 
FROM `volontari` v join utenti u on v.`id_volontari_utenti` = u.id_utenti 
order by u.login_utenti asc

https://stackoverflow.com/questions/31847054/how-to-use-multiple-database-in-laravel


https://sujipthapa.co/blog/laravel-v55-login-register-with-username-or-email



https://jamesmcfadden.co.uk/custom-authentication-in-laravel-with-guards-and-user-service-providers

Authentication in Laravel is centered around guards which allow us to specify varying ways that a user can be authenticated.
The first thing we’ll do is add our own guard for authenticating volontari users. We can do this in /config/auth.php:



https://code.tutsplus.com/tutorials/how-to-create-a-custom-authentication-guard-in-laravel--cms-29667

Guards
You could think of a guard as a way of supplying the logic that’s used to identify the authenticated users. In the core, Laravel provides different guards like session and token. 


Providers
If the guard defines the logic of authentication, the authentication provider is responsible for retrieving the user from the back-end storage. If the guard requires that the user must be validated against the back-end storage then the implementation of retrieving the user goes into the authentication provider. Laravel ships with two default authentication providers—Database and Eloquent.





https://laracasts.com/series/laravel-from-scratch-2017/episodes/17

https://laracasts.com/series/laravel-5-fundamentals/episodes/15



https://git-scm.com/book/it/v1/Git-sul-Server








**I volontari devono __DIVENTARE__ users al posto delle associazioni**

- lo user_id viene messo sulla tabella tblVolontari

- cambiare la relazione tra Associazione e User e diventa tra Volontario e User


- gli utenti che avevo già importato di tipo associazione (quelli generici tipo ARCICACCIA,...) devono avere un volontario corrispondente 
	looop sugli users di tipo "associazione" e creazione di un volontario con:

	associazione_id: trovo associazione con il campo "name"
	user_id: utente corrente
	nome: name
	cognome: vuoto



- loop sui volontari e creazione per ognuno di un record nella tabella users con:
 	ruolo: associazione
 	name: NOME + COGNOME
 	username: NOME + COGNOME + 3 lettere associazione
 	pwd: NOME + COGNOME (da cambiare) 






- Creazione nuovo Volonario/Utente

Se sono volontario devo riempire 2 tabelle:

gli inserimenti li devo fare in una transaction dopo entrambe le validazioni (per la model Volontario e User)



__ELENCO VOLONTARI__

- admin/volontari 

- Volontario::with(['associazione','utente']) legge dalla tabella tblVolontari con eagerLoading ('associazione' e 'utente'), quindi visuliazzo solo i volontari e non gli admin 

__NUOVO VOLONTARIO__

- Volontari > Nuovo => volontari/create => admin.volontari.form => action = [route('register')]

- Auth\RegisterController@register è la route PREDEFINITA di laravel opportunamente modificata per inserire user e volontario in una transaction


__MODIFICA VOLONTARIO__

- volontari/1553/edit => admin.volontari.form => action = [route('utenti.modifica',$volontario->utente->id)]  

- Auth\RegisterController@modificaUtente (modifica utente e/o volontario in una transaction)





__ELENCO ADMIN__

- admin/utenti => Auth\RegisterController@elencoUtenti seleziona solo gli utenti di tipo admin User::withRole('admin')


__NUOVO ADMIN__

- route('register') => Auth\RegisterController@showRegistrationForm => auth.register è il form predefinito di Laravel => action = [route('register')]

- Auth\RegisterController@register è la route PREDEFINITA di laravel opportunamente modificata per inserire user (senza volontario)


__MODIFICA ADMIN__

- utenti/edita/{utente_id} => Auth\RegisterController@editaUtente => auth.register è il form predefinito di Laravel => action = [route('utenti.modifica',$utente->id)]

- Auth\RegisterController@modificaUtente (modifica utente e/o volontario in una transaction)




Rimane il form di adesso, ma 

se sono un utente ASSOCIAZIONE, aggiungo il form del volontario

- una combo per la selezione dell'associazione se sono un utente di quel tipo 
- nome 
- cognome
- registro
- data di nascita
- note 



- spostamento di un volontario da un'associazione ad un'altra

anche cancellandolo da un'associazione non perde mai la relazione con lo user, quindi mantiene il suo login anche nello spostamento.


- fare in modo che alcuni users non possano fare login ???






__FIX__

Auth::user()->associazione->id 

cioè l'associazione a cui appartiene l'utente corrente NON si trova più cosi MA 

Auth::user()->volontario->associazione->id 




#Relazione Associazione-Volontario deve diventare molti-a-molti 

**La necessità  sarebbe quella che il volontario che si sposta ad un'altra associazione riparta da zero ore in quella nuova ma almeno in quella vecchia rimangano i dati storici in visualizzazione e nei report**


- Costruire la tabella di relazione associazione-volontario 
- Importare tutti gli associazione_id,id della "tblVolontari" in associazione-volontario(associazione_id, volontario_id)
- **DEVO** lasciare la colonna associazione_id in "tblVolontari" perché ogni volontario deve vedere solo preventivi e relazioni della sua "Associazione"
- Cambiare le relazioni nelle model
- i dati dello storico devono rimanere nelle relazioni
- Cambiare tutte le chiamate opportunamente nel codice



NOOOOOOOO!!!
QUESTA STRADA E' SBAGLIATA !!!!!


1) Nel momento in cui creo il preventivo, oltre a salvare la associazione, salvo anche i singoli volontari (preventivi-volontari molti-a-molti)
2) Nel momnento in cui creo la relazione oltre a salvare la associazione **DEVO SALVARE** anche i singoli volontari (relazioni-volontari molti-a-molti **ESISTE GIA**)

- devo aggiungere i volontari a tutte le relazioni prendendoli dalle associazioni, quindi praticamente copio 



Quando creo la relazione devo inserire anche i volontari e non solo l'associazione
Quando elenco le relazioni, prendo i volontari associati alla relazione al momento della creazione e non i volontari dell'associazione (in quesro modo se "Massari Walter" non è più in GEV adesso, lo vedo lo stesso nelle relazioni che ho creato quando c'era !!!)



ES: 

Ho creato un preventivo con 2 volontari e li ha messi nella tabella di  relazione
Quando ho creato la relazione ne ho aggiunto uno, sono diventati 3 e li ha messi nella tabella di relazione

 3369 	GEV 	Abati Romano, Amaducci Renzo, Bacchiocchi Sauro 


 cosa succede se tolgo " Amaducci Renzo" da GEV ?? DOvrebbe rimanere nell'elenco delle relazioni e nelle ore (PDF)

GEV Amaducci Renzo 25


In effetti NON RIMANE nell'elenco del PDF perché probabilente seleziono i volontari dall'associazione invece devo prendere quelli di tutte le relazioni

