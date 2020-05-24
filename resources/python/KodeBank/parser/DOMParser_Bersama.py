from htmldom import htmldom as HTML

##
## Parse HTML source from "https://www.atmbersama.com/layanan?sort=ASC"
## to two dimensional array [bank name, bank code]
## Array: [
##		[bank name, bank code],
##		[bank name, bank code],
##		[bank name, bank code],
##		...
##		...
## ]
##
## Important Note:
## - parse algorithm base on HTML source visited on 18th May 2020
##
## @param html - complete html tags
## @return two dimensional array of bank name and bank code
##
def parse(html):
	
	# create the DOM
	dom = HTML.HtmlDom().createDom(html)
	
	# each bank name & bank code grouped in element like bellow:
	# <div class="bank-item"> 
	#	<div class="image">
	#		...
	#	</div>
	#	<div class="text">
	#		<div class="bank">bank name</div>			<--- hold the bank name
	#		<div class="bankcode">bank code</div>		<--- hold the bank code
	#		<div class="callnumber">
	#			...
	#		</div>
	#	</div>
	# </div>
	#
	# so, we need to find the div element "div" with class "text" inside element "div" with class "bank-item"
	t_bankItem = dom.find("div.bank-item > div.text")
	
	# collect result to two dimensional array [bank name, bank code]
	result = []
	for i in range(t_bankItem.length()):
	
		# var bankItem hold html dom like below:
		# <div class="text"> 
		#	<div class="bank"> bank name </div> 		<--- hold the bank name
		# 	<div class="bankcode"> bank code </div> 	<--- hold the bank code
		#	<div class="callnumber"> 
		#		...
		#	</div>
		# </div>
		#
		# so, we get the result with selector "div.bank" for bank name & "div.bankcode" for bank code
		bankName = t_bankItem[i].children("div.bank")
		bankCode = bankName.next()
		result.append([bankName.text().strip(), bankCode.text().strip()])
		
	return result