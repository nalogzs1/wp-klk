<?php
require_once("constants.php");

class Database
{

    private $hashing_salt = "dsaf7493^&$(#@Kjh";
    private $conn;

    /** TODO 1 - Napisati konstruktor klase Database koji inicijalizuje promenljivu $conn na konekciju sa lokalnom MySQL bazom podataka.Za podsetnik o parsiranju konfiguracionih fajlova pogledati poslednje teorijske vežbe.
     **/

    /** TODO 2 - Napisati destruktor klase Database koji uništava sadržaj promenljive $conn.
     **/

    /** TODO 3 - Dopuniti metod insertUser tako da omogućava funkcionalnost dodavanja novog korisnika u bazu podataka, i to akko korisnik ne postoji u bazi podataka.
     * Avatar korisnika određuje se na osnovu pola. Ako je pol z, avatar je avatar_female.png, a u suprotnom avatar_male.png.
     * U bazi je neophodno čuvati hešovan password korisnika. Za više informacija posetite: http://php.net/manual/en/function.crypt.php. Za vrednost promenljive $salt uzmite $hashing_salt iz klase Database.
     **/
    function insertUser($username, $password, $name, $profession, $address, $birthday, $gender)
    {
        return null;
    }

    /** TODO 4 - Dopuniti metod getPosts tako da vraća sve Post-ove za prosleđeni ID korisnika.
     *  Povratnu vrednost metode uskladiti sa kodom iz stranice profile.php (redovi 42 i 104).
     **/

    function getPosts($userId)
    {
        return null;
    }

    /** TODO 5 - Dopuniti metod checkLogin tako da vraća asocijativni niz koji predstavlja jednog korisnika, ako on postoji u bazi podataka.
     **/

    function checkLogin($username, $password)
    {
        return null;
    }

    /** TODO 6 - Dopuniti metod insertPost tako da upisuje u bazu podataka novouneti Post korisnika.
     **/
    function insertPost($content, $userId)
    {
       return null;
    }

}