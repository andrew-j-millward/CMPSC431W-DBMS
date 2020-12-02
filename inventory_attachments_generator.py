import csv, random

linkedList = []

for i in range(1000):
	for j in range(random.randint(1,50)):
		linkedList.append([i+1,random.randint(1,1659)])
	

print(linkedList)
print(len(linkedList))

with open("inventory_attachments.csv", "w", newline="") as csvDoc:
   writer = csv.writer(csvDoc)
   writer.writerows(linkedList)