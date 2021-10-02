var listOfCards=[
"ciri.png",
"geralt.png",
"jaskier.png",
"iorweth.png",
"triss.png",
"yen.png"];

listOfCards=listOfCards.concat(listOfCards);

var cards=shuffleArray(listOfCards);
//alert(cards[]);
//console. log(cards);
var numberOfElements=listOfCards.length;

for(var i=0;i<numberOfElements;i++)
{
  $('.board').append('<div class="card" id="c'+i+'"></div>');
  console.log('c'+i);
  var c=document.getElementById('c'+i);
  console.log(c,$(c));
  $(c).data("index",i);

  c.addEventListener("click",function()
  {
    console.log('następne i',$(this).data("index"),this);
    revealCard($(this).data("index"));
  });

}

var oneVisible=false;
var turnCounter=0;
var visible_nr;
var lock=false;
var pairsLeft=6;

function revealCard(nr)
{
  var opacityValue=$('#c'+nr).css('opacity');
  if(opacityValue!=0 && lock==false)
    {
      lock=true;
      //alert(nr);
      var obraz="url(img/"+cards[nr]+")";
      $('#c'+nr).css('background-image',obraz);
      $('#c'+nr).addClass('cardA');
      $('#c'+nr).removeClass('card');

      if(oneVisible==false)
      {
        //first card
        oneVisible=true;
        visible_nr=nr;
        lock=false;
      }
      else
      {
        //second card
        if(cards[visible_nr]==cards[nr])
        {
          //alert('para');
          setTimeout(function(){hide2Cards(nr, visible_nr)},750);
        }
        else
        {
          //alert('pudło');
          setTimeout(function(){restore2Cards(nr, visible_nr)},1000);
        }
        turnCounter++;
        $('.score').html("Number of moves: "+turnCounter);
        oneVisible=false;
      }

    }

  }

function hide2Cards(nr1,nr2)
{
  $('#c'+nr1).css('opacity','0');
  $('#c'+nr2).css('opacity','0');
  pairsLeft--;
  if(pairsLeft==0)
  {
    $('.board').html('<h1>You Won !!!<br></br>'+'</h1>');
    $('.board').addClass('wygrana');
  }
    lock=false;
}

function restore2Cards(nr1, nr2)
  {
    $('#c'+nr1).css('background-image','url(img/karta.png)');
    $('#c'+nr1).addClass('card');
    $('#c'+nr1).removeClass('cardA');

    $('#c'+nr2).css('background-image','url(img/karta.png)');
    $('#c'+nr2).addClass('card');
    $('#c'+nr2).removeClass('cardA');
    lock=false;
  }

function minecraft()

  {
    document.location.href = "/logowanie/HomePage/gameMinecraft/index.php";
  }


function game()

  {
    document.location.href = "/logowanie/HomePage/game/index.php";
  }

function endGame()

  {
    document.location.href = "/logowanie/HomePage/index.php";
  }

    function shuffleArray ( array )
    {
        var counter = array.length, temp, index;
        // While there are elements in the array
        while ( counter > 0 ) {
            // Pick a random index
            index = Math.floor( Math.random() * counter );

            // Decrease counter by 1
            counter--;

            // And swap the last element with it
            temp = array[ counter ];
            array[ counter ] = array[ index ];
            array[ index ] = temp;
        }
        return array;
    }
