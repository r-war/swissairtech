<?php
/**
 * @package php-font-lib
 * @link    http://php-font-lib.googlecode.com/
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: font_table_cmap.cls.php 40 2012-01-22 21:48:41Z fabien.menager $
 */

/**
 * `cmap` font table.
 * 
 * @package php-font-lib
 */
class Font_Table_cmap extends Font_Table {
  private static $header_format = array(
    "version"         => self::uint16,
    "numberSubtables" => self::uint16,
  );
  
  private static $subtable_header_format = array(
    "platformID"         => self::uint16,
    "platformSpecificID" => self::uint16,
    "offset"             => self::uint32,
  );
  
  private static $subtable_v4_format = array(
    "length"        => self::uint16, 
    "language"      => self::uint16, 
    "segCountX2"    => self::uint16, 
    "searchRange"   => self::uint16, 
    "entrySelector" => self::uint16, 
    "rangeShift"    => self::uint16,
  );
  
  protected function _parse(){
    $font = $this->getFont();
    
    $cmap_offset = $font->pos();
    
    $data = $font->unpack(self::$header_format);
    
    $subtables = array();
    for($i = 0; $i < $data["numberSubtables"]; $i++){
      $subtables[] = $font->unpack(self::$subtable_header_format);
    }
    $data["subtables"] = $subtables;
    
    foreach($data["subtables"] as $i => &$subtable) {
      $font->seek($cmap_offset + $subtable["offset"]);
      
      $subtable["format"] = $font->readUInt16();
      
      // @todo Only CMAP version 4
      if($subtable["format"] != 4) {
        unset($data["subtables"][$i]);
        $data["numberSubtables"]--;
        continue;
      }
      
      $subtable += $font->unpack(self::$subtable_v4_format);
      $segCount = $subtable["segCountX2"] / 2;
      $subtable["segCount"] = $segCount;
      
      $endCode       = $font->r(array(self::uint16, $segCount));
      
      $font->readUInt16(); // reservedPad
      
      $startCode     = $font->r(array(self::uint16, $segCount));
      $idDelta       = $font->r(array(self::int16, $segCount));
      
      $ro_start      = $font->pos();
      $idRangeOffset = $font->r(array(self::uint16, $segCount));
      
      $glyphIndexArray = array();
      for($i = 0; $i < $segCount; $i++) {
        $c1 = $startCode[$i];
        $c2 = $endCode[$i];
        $d  = $idDelta[$i];
        $ro = $idRangeOffset[$i];
        
        if($ro > 0)
          $font->seek($subtable["offset"] + 2 * $i + $ro);
          
        for($c = $c1; $c <= $c2; $c++) {
          if ($ro == 0)
            $gid = ($c + $d) & 0xFFFF;
          else {
            $offset = ($c - $c1) * 2 + $ro;
            $offset = $ro_start + 2 * $i + $offset;
            
            $font->seek($offset);
            $gid = $font->readUInt16()