import csv

with open('tanks_with_cost.csv', 'r', encoding="utf-8") as csvDoc:
	rows = csv.reader(csvDoc)
	resultList = []
	i = 0
	for row in rows:
		i += 1
		resultList.append([i]+[row[1]]+[int(row[2])]+[int(row[0])]+[int(row[3])]+[int(row[4])]+[int(row[5])])

with open('attachments.csv', 'r', encoding="utf-8") as csvDoc:
	rows = csv.reader(csvDoc)
	resultList2 = []
	i = 0
	for row in rows:
		i += 1
		resultList2.append([i]+[str(row[0])]+[str(row[1])]+[str(row[2])]+[str(row[3])]+[int(row[4])]+[int(row[5])]+[str(row[6]).split(',')])

linkedList = []

for i in range(len(resultList2)):
	for j in range(len(resultList)):
		if resultList[j][1] in resultList2[i][7]:
			linkedList.append([resultList[j][0], resultList2[i][0]])

print(linkedList)
print(len(linkedList))

with open("linked.csv", "w", newline="") as csvDoc:
   writer = csv.writer(csvDoc)
   writer.writerows(linkedList)