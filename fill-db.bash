#!/bin/bash

ADD_ROOM_URL="http://localhost:8888/proj/api/room/add"
ADD_ITEM_URL="http://localhost:8888/proj/api/item/add"

SCRIPT_DIR=$(dirname "$(readlink -f "$0")")

ROOMS_FILE="$SCRIPT_DIR/assets/content/proj-assets/rooms.json"
ITEMS_FILE="$SCRIPT_DIR/assets/content/proj-assets/items.json"


ROOMS_JSON=$(cat "$ROOMS_FILE")
ITEMS_JSON=$(cat "$ITEMS_FILE")


# Add rooms
echo "Adding rooms..."

echo "$ROOMS_JSON" | jq -c '.[]' | while IFS= read -r room; do
    name=$(echo "$room" | jq -r '.name')
    description=$(echo "$room" | jq -r '.description')
    path=$(echo "$room" | jq -r '.path')

    img_path="$SCRIPT_DIR/$path"

    curl --location --request POST "$ADD_ROOM_URL" \
    --form "json_data={\"name\":\"$name\",\"description\":\"$description\"}" \
    --form "img=@\"$img_path\""

    echo
done

# Add items
echo "Adding items..."

echo "$ITEMS_JSON" | jq -c '.[]' | while IFS= read -r room; do
    name=$(echo "$room" | jq -r '.name')
    description=$(echo "$room" | jq -r '.description')

    curl --location --request POST "$ADD_ITEM_URL" \
    --header 'Content-Type: text/plain' \
    --data-raw "{
        \"name\":\"$name\",
        \"description\":\"$description\"
    }"

    echo
done

echo "Added rooms and items to database"

