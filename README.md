# PPDB SMA-SMK API Checker: prevent duplicate

## Description
For this API, we provide each other to check if the following information is already inserted in on of our database:
- name
- UN (type, year, number)
- former school

## Logic
UN, we sometimes struggle to understand, why UN in every year can have same number. For that we must use type and year of the UN.  
for this, the format is: `type|year|number`,  
example: `reguler|2016|86-10-012-023-5`

Let's do representation the logic behind this process:
```SQL
SIMILAR_OLIVER(name, "KEISHA ALMA") > 85
AND SIMILAR_OLIVER(formerschool, "SMP YPJ KUALA KENCANA SELATAN") > 85
AND SIMILAR_OLIVER(un, "reguler|2016|86-10-012-023-5") > 85
```

\*here we use oliver algorithm to check the strings if similar. with some precentage (85% hope enough).
Better idea are welcome!  
\*ah yes, use lower case to compare the strings, to make sure avoid case insensitive issue.


## Code Example
In this git project, i made simple example to do this process. with array from csv as dataset.

### API format
**request**  
url: `/api-checker.php`  
querystring:
- name
- untype [reguler, paketA, ..]
- former school

**response**  
a list of students based on what searched.



#### example 1
Here we use plain request.  
API url:
`/api-checker.php?name=KEISHA+ALMA+PRIMASHA&unnumber=86-10-012-022-2&unyear=2016&untype=reguler&formerschool=SMP+YPJ+KUALA+KENCANA+SELATAN`

it will return:
```JSON
[
    {
        "name": "KEISHA ALMA PRIMASHA",
        "unType": "reguler",
        "unYear": "2016",
        "unNumber": "86-10-012-021-4",
        "formerSchool": "SMP YPJ KUALA KENCANA SELATAN"
    },
    {
        "name": "KEYSHA ALMA PRIMASHI",
        "unType": "reguler",
        "unYear": "2016",
        "unNumber": "86-10-012-023-5",
        "formerSchool": "SMP YPJ KUALA KENCANA BARAT"
    }
];
```


#### example 2
Need to use callback?  
API url: `/api-checker.php?name=KEISHA+ALMA+PRIMASHA&unnumber=86-10-012-022-2&unyear=2016&untype=reguler&formerschool=SMP+YPJ+KUALA+KENCANA+SELATAN&callback=somejsonpcallback`

it will return:
```JSON
somejsonpcallback([
    {
        "name": "KEISHA ALMA PRIMASHA",
        "unType": "reguler",
        "unYear": "2016",
        "unNumber": "86-10-012-021-4",
        "formerSchool": "SMP YPJ KUALA KENCANA SELATAN"
    },
    {
        "name": "KEYSHA ALMA PRIMASHI",
        "unType": "reguler",
        "unYear": "2016",
        "unNumber": "86-10-012-023-5",
        "formerSchool": "SMP YPJ KUALA KENCANA BARAT"
    }
]);
```
