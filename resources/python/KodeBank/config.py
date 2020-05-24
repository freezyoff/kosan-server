import parser.DOMParser_Bersama as DOMBersama
import parser.DOMParser_Prima as DOMPrima
	
##
## Define your Argument list
##
systemArguments = {
	"options": "ci",
	"long_options": "CreateDatabase,Import"
}

##
## Define your configuration of URL & DOM Parser
##
handler = [
	# jaringan ATM Bersama
	{
		"url": "https://www.atmbersama.com/layanan?sort=ASC", 
		"parser": DOMBersama,
	},
	
	# jaringan ATM Prima
	{
		"url": "https://www.jaringanprima.co.id/id/kode-bank", 
		"parser": DOMPrima,
	}
]