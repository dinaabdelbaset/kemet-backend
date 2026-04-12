<?php
\DB::update("UPDATE hotels SET image = REPLACE(image, '/images/hotels/', '/hotels-live/')");
\DB::update("UPDATE hotels SET image = REPLACE(image, '/hotels/', '/hotels-live/')");
\DB::update("UPDATE hotels SET gallery = REPLACE(gallery, '/images/hotels/', '/hotels-live/')");
\DB::update("UPDATE hotels SET gallery = REPLACE(gallery, '/hotels/', '/hotels-live/')");
echo "Updated DB\n";
