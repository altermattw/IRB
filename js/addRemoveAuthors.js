var authorScript = $("#Author1").html();
var authorNum = 1;      
var anotherAuthor = function() {
    authorNum++; // increment author number by 1
    var authorN = 'Author'+authorNum+'A';    
    var authorE = 'Author'+authorNum+'D';
    // clone the last .Author class element, including event handlers
    var $authorCl = $("div.Author:last").clone(true);
    // clear the textfield values from the old element
    $authorCl.find('input').val('');
    // update the cloned element with new values
    $authorCl.find('h3').html('Co-author '+authorNum+' (optional)');
    $authorCl.find('.authorName').find('label').attr('for',authorN);
    $authorCl.find('.authorName').find('input').attr({id:authorN,name:authorN});    
    $authorCl.find('.authorEmail').find('label').attr('for',authorE);
    $authorCl.find('.authorEmail').find('input').attr({id:authorE,name:authorE});                   
    // insert the cloned element after the last one
    $("div.Author:last").after($authorCl);        
    // remove the moreAuthors element from the previous Author div
    $("div.Author:eq(-2)").find("#moreAuthors").remove();
    //$("#addAuthor").click(anotherAuthor); // reapply event handler after removal
    $("#remAuthor").show();
  }
var removeAuthor = function() {
    if (authorNum > 1) {
      $("div.Author:eq(-2)").find(".panel-body").append($("#moreAuthors"));            
      $("div.Author:last").remove();
      if (authorNum == 2) $("#remAuthor").hide();
      authorNum--;
    }
}
$("#addAuthor").click(anotherAuthor);
$("#remAuthor").click(removeAuthor);