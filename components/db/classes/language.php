<?php

namespace db;

class Language extends \Orm\Model
{

	protected static $_table_name = 'languages';

	protected static $_properties = array('id', 'label', 'prefix', 'sort');

	public static function getLanguages()
	{
		$result = array();

		foreach(self::find('all') as $lang)
			$result[$lang->id] = $lang->label;

		return $result;
	}

  public static function getLanguagesDatabaseUpdate()
  {
    $result = array();

    foreach(self::find('all') as $lang)
      $result[] = $lang->prefix;

    return $result;
  }

  public static function prefixToId($prefix)
  {
    $search = self::find('first',array(
      'where' => array('prefix'=>$prefix)
    ));

    if(!empty($search))
      return $search->id;

    return false;
  }

  public static function idToPrefix($id)
  {
    $search = self::find($id);

    if(!empty($search))
      return $search->prefix;

    return false;
  }
}