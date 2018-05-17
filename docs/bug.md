


**~NEI FILTRI IMPOSTARE DI DEFAULT ANNO CORRENTE (SIA PER LA VISTA CHE PER EXPORT PDF)~**
~con una select come quella dell'export delle ore di default anno corrente~



1. ~~Nell'elenco delle relazioni di servizio, per ogni relazione, ci deve essere l'ID del preventivo che l'ha generata (ordinabile e ricercabile)~~ 


2. La stampa elenco volontari (di un'associazione) vuole la data: stampa cmq i volonari associati a quell'associazione ADESSSO, oppure si deve tenere traccia di tutti i volontari passati e prendere quelli risalenti a quel periodo ?


3. ~~Nei filtri di ricerca dare la possibilità di escludere quelli cancellati~~


3.1 ~~Stampa dei pdf deve avere il logo e descrivere il filtro~~

3.2 ~~Stampa dei pdf deve avere il logo~~


3.3 ~~Logging error system~~


4. verifica file .env PRIMA DI ANDARE IN PRODUZIONE


5. ~~nei seeder importare anche il flag per cancellato nelle relazioni e nei servizi~~


6. ~Mappa per caricamento località~ 

~> http://blog.chapagain.com.np/google-maps-get-latitudelongitude-value-on-click-and-on-mouse-move/~



7. ~I preventivi in modifica NON SONO EDITABILI DA NESSUNO (neanche PRVINCIA): si può solo ELIMINARE oppure CREARE NUOVO SERVIZIO~

8. ~I servizi in modifica NON SONO EDITABILI DA NESSUNO (neanche PRVINCIA): si può solo elimnare oppure stampare (vedi screen con firme GGV)~




8.2 Nei volontari fare il filtro per associazione con la select box come nei preventivi









9. Nella home link a 2 repo in cui si caricano file (uploadano solo admin e vedono tutti)

Documenti/ Circolari

titolo, argomento, note , Documenti / Circolari (data_upload) [pdf, doc, docx]


10. News/Blog Post (creazione e visualizzazione in home per tutti (solo quelle attive)) 


11. Ripristinare il modifica SOLO per admin 


12. Possibilità di cancellare "Volontario" (cancellazione logica) [ci deve essere un check "escluso o revocato" sopra le note e nelle note specifico il perché (0 ore, o altro)]; però questo diventa sempre una cancellazione logica (devo memorizzare la data in cui viene escluso per fare il filtro per l'export dei volontari delle associazioni)

e poi filtrare con "escludi cancellati" come per i preventivi e nell'elenco dei volonari avere un riconoscimento per quelli "esclusi o revocati"



13. ~Nell'elenco delle Relazioni ci deve essere una colonna che mi dice le ore fatte~







SOLO ASSOCIAZIONI
=============================


DATA PREVENTIVO
1) Inserimento/Modifica: non posso mettere date MINORI DI OGGI


DATA SERVIZIO (solo ASSOCIAZIONI)
2) Creazione: ENTRO 30 gg dalla data del preventivo POSSO CREARE IL SERVIZIO (bottone verde)
Dopo 30 gg il bottone verde è disabilitato


A quel punto l'admin avrà nelle'elenco dei preventivi quelli andate oltre e potrà abilitarle ondemand. A questo punto la relazione creata dal quel preventivo dovrà essere marcata come creata DOPO TEMPO MASSIMO


Elenco dei preventivi ha un campo che ti dice quanti gg mancano ai 30gg dopo l'inizio (questo campo è ordinabile e c'è anche un colore differente per ogni scaglione di avvicinamento)
Anche per gli admin quando filtrano per associazione i preventivi