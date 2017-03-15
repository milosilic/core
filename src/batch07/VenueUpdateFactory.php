<?php
declare(strict_types = 1);

namespace bgw\batch07;

use bgw\batch04\DomainObject;

/* listing 13.42 */
class VenueUpdateFactory extends UpdateFactory
{
    public function newUpdate(DomainObject $obj): array
    {
        // note type checking removed
        $id = $obj->getId();
        $cond = null;
        $values['name'] = $obj->getName();

        if ($id > -1) {
            $cond['id'] = $id;
        }

        return $this->buildStatement("venue", $values, $cond);
    }
}
/* /listing 13.42 */
