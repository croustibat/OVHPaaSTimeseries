# OVHPaaSTimeseries
Simple class to wrap OVH Paas Timeseries plateform. 
Check OVH project here : https://www.runabove.com/iot-paas-timeseries.xml

# How to use 

Instanciate the class and call the read or write method by proving datas, token id + token key :

```
require_once __DIR__.'/ovhiot.php';

$ovhiot = OvhIOT::getInstance();
$data = [
  'metric'    => 'temperature',
  'timestamp' => time(),
  'value'     => $myvalue,
  'tags'      => [ 'mytag' => 'value1' ]
];

$ovhiot->write($data, $write_token_id, $write_token_key);

//or

$ovhiot->read($data, $read_token_id, $read_token_key);

```
