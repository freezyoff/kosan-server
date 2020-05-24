from htmldom import htmldom as HTML

##
## Parse HTML source from "https://www.jaringanprima.co.id/id/kode-bank" 
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
	# <table> 
	#	<tr>
	#		<td class="bank_textcol">row number</td>
	#		<td class="bank_namecol">bank logo</td>
	#		<td class="bank_textcol text-left">bank name</td>		<--- hold the bank name
	#		<td class="bank_codecol">bank code</td>					<--- hold the bank code
	#	</tr>
	# </table>
	#
	# so, we need to find the div element "div" with class "text" inside element "div" with class "bank-item"
	t_code = dom.find("td.bank_codecol")
	
	# collect result to two dimensional array [bank name, bank code]
	result = []
	for i in range(t_code.length()):
		bankCode = t_code[i]
		bankName = t_code[i].prev()
		result.append([
			bankName.text().strip(),
			bankCode.text().strip()
		])
		
	return result
	