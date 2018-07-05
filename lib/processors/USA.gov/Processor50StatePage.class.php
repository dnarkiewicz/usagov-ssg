<?php

namespace ctac\ssg;

class Processor50StatePage extends ProcessorMain
{
  function process( &$params )
  {
    parent::process($params);

    if ( !isset($this->directoryRecordsByAgency['State Government Agencies']) )
    {
      return $params;
    }
    $states = $this->directoryRecordsByAgency['State Government Agencies'];
    $stateParams = [];
    foreach ( $states as $uuid=>$record )
    {
        // if ( !empty($record['field_state_details']['und'][0]['nid']) )
        //      // && !empty($this->source->entities[$record['field_state_details']['und'][0]['nid']]) )
        // {
        //     var_dump(
        //         $this->ssg->source->entitiesById['nid'][ $record['field_state_details']['und'][0]['nid'] ]
        //     );die;
        // }
        $stateList = [
            'name'=>$record['title'],
            'url'=>'https://'.
                $this->ssg->config['siteUrl'].
                $page['field_friendly_url']['und'][0]['value'].
                '/'.
                $this->ssg->source->entities[$record['field_state_details']['und'][0]['nid']]
        ];
    }
    array_merge( $params, [ 'stateList' => $stateList ] );
  }
}
