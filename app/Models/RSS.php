<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 10/11/2016
 * Time: 4:14 PM
 */

namespace App;


class RSS
{
	public function GetFeed()
	{
		return $this->getDetails() . $this->getItems();
	}

	private function getDetails()
	{
		$result = WebrefRssDetails::select()->toArray();

		foreach ($result as $row)
		{
			$details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
    <rss version="2.0">
     <channel>
      <title>'. $row['title'] .'</title>
      <link>'. $row['link'] .'</link>
      <description>'. $row['description'] .'</description>
      <language>'. $row['language'] .'</language>
      <image>
       <title>'. $row['image_title'] .'</title>
       <url>'. $row['image_url'] .'</url>
       <link>'. $row['image_link'] .'</link>
       <width>'. $row['image_width'] .'</width>
       <height>'. $row['image_height'] .'</height>
      </image>';
		}
		return $details;
	}

	private function getItems()
	{
		$itemsTable = "webref_rss_items";
		$this->dbConnect($itemsTable);
		$query = "SELECT * FROM ". $itemsTable;
		$result = WebrefRssItems::select()->toArray();
		$items = '';
		foreach ($result as $row)
		{

		}
		while($row = mysql_fetch_array($result))
		{
			$items .= '<item>
    <title>'. $row["title"] .'</title>
    <link>'. $row["link"] .'</link>
    <description><![CDATA['. $row["description"] .']]></description>
   </item>';
		}
		$items .= '</channel>
    </rss>';
		return $items;
	}

}
