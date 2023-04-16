
GET [api/quote](/api/quote)

Presents random quote of the day with todays date and timestamp.

GET [api/deck](/api/deck)

Returns a sorted JSON deck.

POST [api/deck/shuffle](/api/deck/shuffle)

Returns a shuffled JSON deck.

POST [api/deck/draw](/api/deck/draw)

Returns 1 drawn card and the number of cards left in deck.

POST [api/deck/draw/:number](/api/deck/draw/:number)

Returns {number} drawn cards and the number of cards left in deck.

POST [api/deck/deal/:players/:cards](/api/deck/deal/:players/:cards)

Returns the {cards} dealt to each {players} and the number of cards left in deck.

