# encoding: utf-8
import json
import jieba
import jieba.analyse
import requests
import csv


keyword_list = ['狗狗','貓咪','寵物','主人','毛孩','飼養','可愛']


def is_article_match(article):
    tags = jieba.analyse.extract_tags(article, 20)
    s1 = set(keyword_list)
    s2 = set(tags)
    if len(s1.intersection(s2))>=2 :
        return tags
    else:
        return False
    

s = "http://140.115.82.103/PetCity_getData/Pet_Articles_201710.json"
res = requests.get(s)
data = json.loads(res.text)
    
# with open('Pet_Articles.json', 'r') as f:
#     data = json.load(f)



#產生文字雲json檔

petArticles = []
keywords_of_all_articles_set = {"寵物"}

count = 1
for item in data:
    keyword_tags = is_article_match(item['post_message'])
    if keyword_tags:
#         print(count,".------------------------------------------------")
        count = count + 1
#         print(keyword_tags)
#         print(item['post_id'])
#         print(item['post_updated_time'])
#         print(item['post_likes'])
#         print(item['post_from'])
#         print(item['post_from_id'])
#         print(item['post_link'])
#         print (item['post_message'])
        item['keyword'] = keyword_tags
        keywords_of_all_articles_set = keywords_of_all_articles_set.union(set(keyword_tags))
    
#         print(item)
#         print ("\n")
#         article = {}
#         article['post_updata_time'] = item['post_updata_time']
#         article['post_likes'] = item['post_likes']
#         article['post_from'] = item['post_from']
#         article['post_from_id'] = item['post_from_id']
#         article['post_link'] = item['post_link']
#         article['post_message'] = item['post_message']
        if item['post_from']!='《HITO 本舖》':
            petArticles.append(item)        
    
#print(keywords_of_all_articles_set)
keywords_of_all_articles_set = list(keywords_of_all_articles_set)
# print(petArticles)

wordcloud_array = []
wordcloud_dictionary = {}

url_dictionary = {}
postid_dictionary = {}
postfrom_dictionary = {}
posttime_dictionary = {}
postmessage_dictionary = {}

postid_array = []
url_array = []
postfrom_array = []
postmessage_array = []
posttime_array = []

stop_word = ['goo','gl','...','我們','https','1vwmvd','一樣','加入','想要','以為','區貓','每天','趕快']

for i in keywords_of_all_articles_set:
    count = 0
    for j in petArticles:
        if i in j['keyword']:
#             print(i+","+str(j['keyword']))
            count = count+1 
            postid_dictionary['name'] = j['post_id']
            postid = postid_dictionary['name']
            postid_array.append(postid)
            url_dictionary['name'] = j['post_link']
            url = url_dictionary['name']
            url_array.append(url)
            postfrom_dictionary['name'] = j['post_from']
            postfrom = postfrom_dictionary['name']
            postfrom_array.append(postfrom)    
            postmessage_dictionary['name'] = j['post_message']
            postmessage = postmessage_dictionary['name']
            postmessage_array.append(postmessage) 
            posttime_dictionary['name'] = j['post_created_time']
            posttime = posttime_dictionary['name']
            posttime_array.append(posttime)
    
    if count > 1:
        wordcloud_dictionary['text'] = i
        wordcloud_dictionary['size'] = count
        wordcloud_dictionary['postid'] = postid_array
        wordcloud_dictionary['url'] = url_array
        wordcloud_dictionary['postfrom'] = postfrom_array
        wordcloud_dictionary['postmessage'] = postmessage_array
        wordcloud_dictionary['posttime'] = posttime_array
        if not wordcloud_dictionary['text'] in stop_word :
            wordcloud_array.append(wordcloud_dictionary)
    postid_array = []
    url_array = []
    postfrom_array = []
    postmessage_array = []
    posttime_array = []
    wordcloud_dictionary ={}
    
wordcloud_array = sorted(wordcloud_array,key=lambda k: k['size'],reverse=True)

wordcloud_array =  wordcloud_array[0:22]

print(wordcloud_array)


json.dump(wordcloud_array,open("C:\AppServ\www\PetCity\petArticles\data\CloudData.json","w"))




#產生泡泡圖csv檔
data.reverse()
petArticles = [['id','post_from_id','post_from','post_updated_time','post_created_time'
               ,'post_link','post_message','post_name','post_type',
               'post_likes','post_shares','post_comments','post_reactions']]
count = 1
for item in data:
    if is_article_match(item['post_message']):
        if item['post_type'] != 'status':
            eachData_csvform = []
            eachData_csvform.append(count)
            eachData_csvform.append(item['post_from_id'])
            eachData_csvform.append(item['post_from'])
            eachData_csvform.append(item['post_updated_time'])
            eachData_csvform.append(item['post_created_time'])
            eachData_csvform.append(item['post_link'])
            eachData_csvform.append(item['post_message'])
            eachData_csvform.append(item['post_name'])
            eachData_csvform.append(item['post_type'])
            eachData_csvform.append(item['post_likes'])
            eachData_csvform.append(item['post_shares'])
            eachData_csvform.append(item['post_comments'])
            eachData_csvform.append(item['post_reactions'])
            petArticles.append(eachData_csvform)
            count = count+1
print(petArticles)

f = open("C:\AppServ\www\PetCity\petArticles\data\BubbleData.csv","w", newline='',encoding = 'utf8')
w = csv.writer(f)
w.writerows(petArticles)
f.close()

