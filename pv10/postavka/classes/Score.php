<?php 
class Score {
    private $resultP1;
    private $resultP2;
    private $player1;
    private $player2;

    public function __construct($line){
        $this->player1 = $line[0];
        $this->player2 = $line[1];
        $this->resultP1 = $line[2];
        $this->resultP2 = $line[3];
    }

    public function get_html() {
        if ($this->resultP1 == $this->resultP2) {
            $klasa_p1 = $klasa_p2 = "yellow";
        } else {
            $klasa_p1 = $this->resultP1 < $this->resultP2 ? "red" : "blue";
            $klasa_p2 = $this->resultP1 > $this->resultP2 ? "red" : "blue";
        }
        return "<tr><td class=\"$klasa_p1\">".($this->player1)."(".($this->resultP1).")</td><td class=\"$klasa_p2\">".($this->player2)."(".($this->resultP2).")</td></tr>";
    }

    public function get_csv(){
        return "\n".$this->player1 . ";" . $this->player2 . ";" . $this->resultP1 . ";" . $this->resultP2;
    }
}
?>