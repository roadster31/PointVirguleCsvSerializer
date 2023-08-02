<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace PointVirguleCsvSerializer\Serializer;

use Thelia\Core\Serializer\Serializer\CSVSerializer;

class PointVirguleCSVSerializer extends CSVSerializer
{
    /**
     * @var string CSV delimiter char
     */
    protected $delimiter = ';';

    public function getMimeType()
    {
        return "application/vnd.ms-excel";
    }

    public function getName()
    {
        return "CSV for Excel";
    }

    public function serialize($data)
    {
        $csvRow = parent::serialize($data);

        return utf8_decode(preg_replace("/(\d+)\.(\d+)/", "$1,$2", $csvRow));
    }

    public function unserialize(\SplFileObject $fileObject)
    {
        $data = parent::unserialize($fileObject);

        foreach ($data as &$item) {
            foreach ($item as &$value) {
                if (!preg_match('!!u', $value)) {
                    $value = utf8_decode($value);
                }
            }
        }

        return $data;
    }
}
