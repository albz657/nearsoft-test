<?php
/**
 * Created by PhpStorm.
 * User: pecalleja
 * Date: 08/12/2017
 * Time: 12:38 AM
 */

namespace AppBundle\Util;


class sumNumbers
{
    /**
     * variante que siempre hace las tres divisiones
     *
     * @return int
     */
    public function sumNumbersA()
    {
        $suma = 0;
        for($i = 1; $i<=1000; $i++)
        {
            if($i%3 == 0 and $i%5 == 0 and $i%7 ==0)
            {
                $suma = $suma + $i;
            }
        }
        return $suma;
    }

    /**
     * variante optimizada para solo dividir si se requiere
     * usando solo 3 multiplos solamente no ve casi la diferencia
     * si se agregaran mas es posible que sea mas eficiente iterar que dividir siempre
     * @return int
     */
    public function sumNumbersB()
    {
        $suma = 0;
        $multiplos = [3, 5, 7];
        for($i = 1; $i<=1000; $i++)
        {
            foreach ($multiplos as $j)
            {
                if($i%$j !== 0)
                    continue 2;
            }

            $suma = $suma + $i;

        }
        return $suma;
    }


}