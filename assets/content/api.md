
GET [api/quote](./api/quote)

Presents random quote of the day with todays date and timestamp.

GET [api/deck](./api/deck)

Returns a sorted JSON deck.

POST [api/deck/shuffle](./api/deck/shuffle)

Returns a shuffled JSON deck.

POST [api/deck/draw](./api/deck/draw)

Returns 1 drawn card and the number of cards left in deck.

POST [api/deck/draw/:number](./api/deck/draw/3)

Returns {number} drawn cards and the number of cards left in deck.

POST [api/deck/deal/:players/:cards](./api/deck/deal/3/3)

Returns the {cards} dealt to each {players} and the number of cards left in deck.

GET [api/game](./api/game)

Returns gamestate of current 21 game.

GET [api/library/books](./api/library/books)

Return all books in library.

GET [api/library/book/:isbn](./api/library/book/978-1-2345-6789-1)

Return book with {isbn}.
