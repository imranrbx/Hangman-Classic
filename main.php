<?php
/*
    Function Name: fetchWordArray()
    Parameters: None
    Return values: Returns an array of characters.
*/
    function fetchWordArray($wordFile)
    {
        $file = fopen($wordFile,'r');
           if ($file){
            $random_line = null;
            $line = null;
            $count = 0;
            while (($line = fgets($file)) !== false){
                $count++;
                if(rand() % $count == 0){
                      $random_line = trim($line);
                }
        }
        if (!feof($file)) {
            fclose($file);
            return null;
        }else {
            fclose($file);
        }
    }
        $answer = str_split($random_line);
        return $answer;
    }
/*
    Function Name: hideCharacters()
    Parameters: Word whose characters are to be hidden.
    Return values: Returns a string of characters.
*/
    function hideCharacters($answer)
    {
        $noOfHiddenChars = floor((sizeof($answer)/2) + 1);
        $count = 0;
        $hidden = $answer;
        while ($count < $noOfHiddenChars )
        {
            $rand_element = rand(0,sizeof($answer)-2);
            if( $hidden[$rand_element] != '_' ){
                $hidden = str_replace($hidden[$rand_element],'_',$hidden,$replace_count);
                $count = $count + $replace_count;
            }
        }
        return $hidden;
    }
/*
    Function Name: checkAndReplace()
    Parameters: UserInput, Hidden string and the answer.
    Return values: Returns a character array.
*/
    function checkAndReplace($userInput, $hidden, $answer)
    {
        $i = 0;
        $wrongGuess = true;
        while($i < count($answer)){
            if ($answer[$i] == $userInput){
                $hidden[$i] = $userInput;
                $wrongGuess = false;
            }
            $i = $i + 1;
        }
        if (!$wrongGuess) $_SESSION['attempts'] = $_SESSION['attempts'] - 1;
        return $hidden;
    }
    
    
/*
    Function Name: checkGameOver()
    Parameters: Maximum attempts, no. of attempts made by user, Hidden string and the answer.
    Return values: Returns a character array.
*/
    function checkGameOver($MAX_ATTEMPTS,$userAttempts, $answer, $hidden)
    {
        if ($userAttempts == $MAX_ATTEMPTS){
            $_SESSION['answer'] = $answer;
               return 0;
               /* echo "<p style='text-align:center;'><span style='font-weight:bold;color:organe;'>Game Over!</span> The correct word was <b>";
                 $letter = implode("",$answer);
                echo $letter;                
                echo '</b></p><br><form action = "" method = "post"><input data-role="button" type = "submit" name = "newWord" value = "Try another Word"/></form><br>';
                      session_destroy();
               die();*/
            }
            if ($hidden == $answer){
                $_SESSION['answer']=$answer;
                return 1;
                /*echo "<p style='text-align:center;'><span style='font-weight:bold;color:organe;'>Game Over!</span> The correct word is indeed was <b>";
                $letter = implode("",$answer);
                echo $letter;              
                echo '</b></p><br><form action = "" method = "post"><input data-role="button" type = "submit" name = "newWord" value = "Try another Word"/></form><br>';
                   session_destroy();
              die();*/
                
            }
    }

    function getLetters($char=array())
    {     
        if(isset($char) and count($char)> 0) {
            for($i=65; $i<=90; $i++){
                if(in_array(strtolower(chr($i)),$char)){
                    continue;
                }else{
                    $letters[] = strtolower(chr($i));
                }
            }
        } else {
            for($i=65; $i<=90; $i++){
                $letters[] = strtolower(chr($i));
            }

        }

        return $letters;

    }
?>