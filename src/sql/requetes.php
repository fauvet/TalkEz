<?php

	// Récupérer tous les tweets (liens) reliés à un évènement (identifié par son ID)
	function selectTweets(id_event) {
		"SELECT TWEET.LIEN
		FROM EVENT EVT, TWEET TWT, DESIGNER DSG
		WHERE EVT.ID = DSG.EVENT_ID
		where e.id = d.event_id
		and d.tweet_id = tw.id
		and e.id = :idEvt;"
	}

	// Récupérer l'ID d'un évènement avec son libellé
	
	select id
	from Event
	where libelle like :libelleEvt;
	
	// Récupérer les types d'évènements (Libelle)
	
	select libelle
	from Type;
	
	// Récupérer tous les messages (contenu) liés à un évènement donné (par son ID), triés par heure
	
	select m.contenu
	from message m, event e
	where m.id_event = e.id
	and e.id = :idEvt
	order by m.heure;
	
	// Récupérer les liens utiles relatifs à un évènement (donné par son ID) triés par poids
	
	select li.lien
	from Lien_Utile li, Informer2 i2, Event e
	where e.id = i2.event_id
	and i2.lien_utile_id = li.id
	and e.id = :idEvt
	order by li.poids;
	
	// Récupérer les liens utiles relatifs à un message (donné par son ID) triés par poids
	
	select li.lien
	from Lien_Utile li, Informer1 i1, Message m
	where m.id = i1.message_id
	and i1.lien_utile_id = li.id
	and m.id = :idMsg
	order by li.poids;
?>
