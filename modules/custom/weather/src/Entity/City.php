<?php


namespace Drupal\weather\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the Advertiser entity.
 *
 * @ingroup city
 *
 * @ContentEntityType(
 *   id = "city",
 *   label = @Translation("City"),
 *   base_table = "city",
 *   entity_keys = {
 *     "id" = "id",
 *   },
 * )
 */

class City extends ContentEntityBase implements ContentEntityInterface {

     public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

        // Standard field, used as unique if primary index.
        $fields['id'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('ID'))
            ->setDescription(t('The ID of the Advertiser entity.'))
            ->setReadOnly(TRUE);

        $fields['city_name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('City Name'))
            ->setDescription(t('The city name.'))
            ->setSettings(array(
                'default_value' => '',
                'max_length' => 20,
                'text_processing' => 0,
            ))
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => -6,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'string_textfield',
                'weight' => -6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['country_code'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Country Code'))
            ->setDescription(t('Country code, use ISO 3166 country codes.'))
            ->setSettings(array(
                'default_value' => '',
                'max_length' => 3,
                'text_processing' => 0,
            ))
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => -5,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'string_textfield',
                'weight' => -5,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        return $fields;
    }
}
