<?php
/**
 * @author Anton Lytkin <anton.lytkin18@gmail.com>
 */

namespace WS\Entity;

use WS\ActiveRecord\ActiveRecord;

/**
 * Class Movies
 *
 * @property int $id ID
 * @property string $name NAME
 * @property string $author AUTHOR
 * @property string $description DESCRIPTION
 *
 * @table movies
 *
 */

class Movies extends ActiveRecord {

}