window.stripeGenerator = new function(){


	/* ADAPTER */
	filler = "-";
	spacer = ' ';

	input = $('.editor').children();
	paperWidth = formatMeasure($('.editor').width());
	initPaperTextStartPos = getLeftPos($('.editor'));
	currPaperTextStartPos = getLeftPos($('.editor'));


	//measurement
	var maxLetterInRow = 70;
	var currMaxLength = 70;
	var tabLetterCount = 5;


	/* UI PROCESSOR */
	input.each(function( index ) {

		//policies
		var orientation = detectAlignment($(this)['0'].outerHTML);
		if( validateObjectPolicies($(this)['0'].tagName) == true && validateAlignmentPolicies(orientation) == true ){

			// initialize
			var fontSize = parseInt($(this).css('font-size'), 10);
			var arrTmpText = splitByTag(formatSpaces($(this)['0'].innerHTML));
			var newHtmlText = "";
			var newText = "";
			var textInRow = "";
			var noSpaceFlag = false;

			// add anchor for middle text alignment
			if(orientation == "center"){

				// re-align
				$($(this)['0']).css('text-align', 'left');
	
				newHtmlText = cleanExceededSpace(newHtmlText);
				newHtmlText = newHtmlText + '<FillerReplaceHere/>';
				// noSpaceFlag = true; --> 
			}


			// console.log(arrTmpText); -->
			//functions
			$.each(arrTmpText, function( arrTmpTextIndex, value ) {
				// console.log(getTag(value)); -->

				var arrCleanedText = cleanTag(value).split(" ");

				// add html objects
				var currHtmlObject = getTag(value);
				if(currHtmlObject != null){				

					if(currHtmlObject == '<br>' || currHtmlObject == '</br>'){
						// new line?
						// console.log(textInRow); -->
						// console.log('newline'); -->

						// clean exceeding spaces
						textInRow = cleanExceededSpace(textInRow);


						// last element?
						if(arrTmpText[arrTmpTextIndex + 1] != null){
						
							// fill with filler
							newHtmlText = addFiller(newHtmlText, textInRow, currMaxLength, orientation);

							// reset counter and add to main html text
							textInRow = "";
							tmpTextInRow = "";
							newHtmlText = newHtmlText + spacer ;

						}

						noSpaceFlag = true;

					}else if(currHtmlObject == '</li>' ){

						// list closing
						// console.log(textInRow); -->
						// console.log('listClosing'); -->

						// clean exceeding spaces
						textInRow = cleanExceededSpace(textInRow);


						// last element?
						if(arrTmpText[arrTmpTextIndex + 1] != null){

							// fill with filler
							newHtmlText = addFiller(newHtmlText, textInRow, currMaxLength, orientation);

							// reset counter and add to main html text
							textInRow = "";
							tmpTextInRow = "";
							// console.log(textInRow); -->
							// console.log(textInRow.length); -->
							newHtmlText = newHtmlText + currHtmlObject + spacer ;

						}

						noSpaceFlag = true;

					}else if(currHtmlObject == '<li>' ){
						newHtmlText = cleanExceededSpace(newHtmlText);
						newHtmlText = newHtmlText + getTag(value) + spacer;

						noSpaceFlag = true;
					}else{
						// normal text
						// console.log('get spaced here'); -->

						newHtmlText = cleanExceededSpace(newHtmlText);

						if(noSpaceFlag == true){

							noSpaceFlag = false;

							textInRow = cleanExceededSpace(textInRow);
							newHtmlText = newHtmlText + getTag(value);
						}else{
							newHtmlText = newHtmlText + getTag(value) + spacer;
						}

						// tabs
						if(currHtmlObject == '<ol>' || currHtmlObject == '<ul>'){
							currMaxLength = currMaxLength - tabLetterCount;
						}else if (currHtmlObject == '</ol>' || currHtmlObject == '</ul>'){
							currMaxLength = currMaxLength + tabLetterCount;
						}							

					}
				}

				// add text 
				$.each(arrCleanedText, function( arrCleanedTextIndex, value ) {
					// console.log(textInRow.length); -->
					// console.log(textInRow); -->
					// console.log(value); -->
					// console.log(arrCleanedText); -->

					// proceed is value exist
					if(canAddText(value) == true){
						// init
						tmpTextInRow = textInRow;
						textInRow = textInRow + value;

						// console.log('bocor'); -->

						// count and format text in one row
						// console.log(textInRow); -->
						if(textInRow.length > currMaxLength){

							// clean exceeding spaces
							// newHtmlText = cleanExceededSpace(newHtmlText); -->
							textInRow = cleanExceededSpace(tmpTextInRow);

							// fill with filler
							newHtmlText = addFiller(newHtmlText, textInRow, currMaxLength, orientation);

							// reset counter and add to main html text
							// console.log(value); -->
							// console.log(textInRow); -->
							textInRow = value + spacer;
							newHtmlText = newHtmlText + value + spacer ;
							
						}else{
							// console.log(textInRow); -->
							// console.log(newHtmlText); -->
							// console.log(textInRow.length); -->
							newHtmlText = newHtmlText + value;
							textInRow = addSpacer(textInRow, textInRow.length,  currMaxLength);

							if(arrCleanedText[arrCleanedTextIndex + 1]){
								newHtmlText = addSpacer(newHtmlText, textInRow.length, currMaxLength);
							}

						}
					}			
				});		

			});

			// fill last row in object
			textInRow = cleanExceededSpace(textInRow);
			newHtmlText = addFiller(newHtmlText, textInRow, currMaxLength, orientation);

			// clean
			textInRow = "";

			// inject to page
			$(this).html(newHtmlText);

		}
	});	

	/* POLICIES */
	function validateObjectPolicies(tag){

		// rules here

		// banned
		if(tag == 'H4'){
			return false;
		}

		// extra calculation
		if(isTabbed(tag) == true){
			decreaseMaxLength();
			return true;
		}

		// noramalize
		resetMaxLength();
		return true;
	}
	function validateAlignmentPolicies(tag){
		return true;
	}
	function canAddText(e){
		if(e.match(/\s/g)){
			return false;
		}else if(e.match(/\n/ig)){
			return false;
		}else if(!e){
			// console.log(e); -->
			// return false; -->
		}

		return true;
	}


	/* TEXT FORMATTER */
	function splitByTag(e){
		return e.split(/(?=<.*?(.*?).*?>)/g);
	}
	function cleanTag(e){
		return e.replace(/<.*?(.*?).*?>/g, '');
	}	
	function getTag(e){
		return e.match(/<.*?(.*?).*?>/g);
	}

	/* FILLER */
	function addFiller(e, textInRow, maxLength, orientation){
		// Check Orientation
		if(orientation == 'left'){

			// get text length
			textLength = getTextLength(textInRow);

			// check prev spaces
			if(textLength > 0){
				if(isSpaced(e) == true){
					textLength++;
				}
			}

			// get filler length
			numberOfFiller = maxLength - textLength;
			if(numberOfFiller == maxLength)
			{
				// remove the last space is any
				textInRow = cleanExceededSpace(textInRow);
				e = cleanExceededSpace(e);

				numberOfFiller = maxLength - textLength;
			}

			// fill
			return e + '<span style="font-weight: initial !important;">' + insertStripeFromRight(numberOfFiller) + '</span><br>';
			// return e + '<span style="font-weight: initial !important;"></span></br>'; -->

			// return e + '<span style="font-weight: initial !important;">|' + textLength + '|</span></br>'; -->

		}else{

			// add spaces on first non html object 

			// after tag replacer
			var spacePos = 20;
			var charPointed = e.charAt(spacePos);

			if(charPointed != '<'){

				var blockedChar = ['-', ' '];

				if(blockedChar.indexOf(charPointed) < 0){
					e = e.slice(0, spacePos) + " " + e.slice(spacePos);
				}

			}


			// get text length
			textLength = getTextLength(textInRow);

			// check prev spaces
			if(textLength > 0){
				if(isSpaced(e) == true){
					textLength++;
				}
			}

			// remove the last space is any
			textInRow = cleanExceededSpace(textInRow);

			if(isSpaced(e) == true){
				e = cleanExceededSpace(e);
			}

			// get filler length
			numberOfFiller = maxLength - textLength;

			// get left and right
			var l = Math.floor(numberOfFiller / 2);
			var r = Math.ceil(numberOfFiller / 2);


			// fill left
			var tmpFiller =  '<span style="font-weight: initial !important;">' + insertStripeFromRight(l) + '</span>';
			e = e.replace("<FillerReplaceHere/>", tmpFiller);

			// fill right
			return e + '<span style="font-weight: initial !important;">' + insertStripeFromRight(r) + '</span><br>';

		}
	}
	function insertStripeFromLeft(n){
		return e;
	}
	function insertStripeFromRight(n){
		var tmpStripe = "";

		for(i = 0; i < n; i++){
			tmpStripe = tmpStripe + filler;
		}

		return tmpStripe;
	}

	/* TEXT LENGTH */
	function getTextLength(e){
		firstChar = e.charAt(0);

		if(firstChar.match(/\s/g)){
			return (e.length - 1)
		}
		return e.length;
	}


	/* SPACES */
	function cleanExceededSpace(e){
		if(isSpaced(e) == true){
			return e.slice(0, -1);
		}
		return e;
	}
	function addSpacer(e, currLength, max){
		if(currLength < (max)){
			if(isSpaced(e) == false){
				e = e + spacer;
			}
		}
		return e;
	}
	function formatSpaces(e){
		return e.replace(/&nbsp;/g, " ");
	}
	function isSpaced(e){
		if(e.slice(-1) == " "){
			return true;
		}
		return false;
	}

	/* TABS */
	function isTabbed(e){
		if(e == 'OL'){
			return true;
		}else if(e == 'UL'){
			return true;
		}

		return false
	}
	function increaseMaxLength(){
		currMaxLength = currMaxLength + tabLetterCount;
	}
	function decreaseMaxLength(){
		currMaxLength = currMaxLength - tabLetterCount;
	}
	function resetMaxLength(){
		currMaxLength = maxLetterInRow;
	}


	/* ALIGNMENT */
	function detectAlignment(e){
		if (/text-align: center/i.test(e)){
			return "center";
		}else{
			return "left";
		}
	}

	/* POSITION */
	function getLeftPos(e){
		return formatMeasure(e.offset().left);
	}


	/* CONVERTER */
	function formatMeasure(n){
		return parseFloat(n.toFixed(2));
	}

    function convertCM(px){
    	return parseFloat((px/37.795276).toFixed(2));
    }

    function convertPX(cm){
    	return parseFloat((cm*37.795276).toFixed(2));
    }	
}