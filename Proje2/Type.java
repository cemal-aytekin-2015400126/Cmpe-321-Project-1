/*
 * Author: Cemal AYTEKÝN
 */
import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.RandomAccessFile;
import java.util.Scanner;

public class Type {
	String typeName;
	int numOfFields;
	int numOfRecordsEachPage;
	int numOfRecords;
	int numOfPages;
	String[] fieldNames;
	long location;
	String[] fields;
	Scanner console = new Scanner(System.in);

	void createType(String typeName) throws IOException {				//This function create a type and its file
		System.out.print("\nNumber of fields: ");

		numOfFields = console.nextInt();

		while(numOfFields > 8) {
			System.out.println("\nERROR: Number of fields cannot be more than 8!\n");
			System.out.print("Enter a vaild number of fields: ");
			numOfFields = console.nextInt();
		}

		fieldNames = new String[numOfFields];
		//Take the field names from the user
		System.out.println("\nField names:\n");
		for(int i = 1; i <= numOfFields; i++) {
			System.out.print("field name #"+i+": ");
			String fieldName = console.next();
			while(fieldName.length() > 12) {
				System.out.println("ERROR: Field name cannot be more than 12 characters!");
				System.out.print("field name #"+i+": ");
				fieldName = console.next();
			}
			while(fieldName.length()!=12) {
				fieldName+="*";
			}
			fieldNames[i - 1] = fieldName;
		}

		File f = new File("Files/" + typeName + ".txt");			//Create the type's file
		RandomAccessFile raf = new RandomAccessFile(f, "rw");
		raf.writeInt(0); 			// set initaik number of Records to 0
		raf.writeInt(numOfFields);  // set number of Fields

		for(int i=0; i<numOfFields; i++) {
			raf.writeUTF(fieldNames[i]);
		}
		for(int i=numOfFields; i<8; i++) {
			raf.writeUTF("************");
		}
		
		raf.close();
	}
	
	void insertRecord(String typeName) throws IOException {			//this function insert a record to the related file
		this.typeName = typeName;
		File f1 = new File("Files/" + typeName + ".txt");			//get the record's type's file
		RandomAccessFile raf = new RandomAccessFile(f1, "rw");
		readTypeHeader(typeName);
		fields = new String[numOfFields];
		System.out.print("Enter record id: ");
		int recordID = console.nextInt();
		while(isRecordExists(recordID, typeName)) {
			System.out.println("\nERROR: This record ID has been already used!");
			System.out.print("Enter another record ID: ");
			recordID = console.nextInt();
		}		
		numOfRecords++;
		raf.seek(0);
		raf.writeInt(numOfRecords);
		raf.seek(raf.length());
		raf.writeInt(recordID);
		raf.writeByte(0); // isDeleted

		System.out.println();
		for(int i=0; i<numOfFields; i++) {
			System.out.print(fieldNames[i]+": ");
			fields[i] = console.next();
			while(fields[i].length()>12) {
				System.out.println("Values must be less than 12 characters long");
				System.out.print(fieldNames[i]+": ");
				fields[i] = console.next();
			}
			for(int k=fields[i].length(); k<12; k++) {
				fields[i]+="*";
			}
			raf.writeUTF(fields[i]);
		}	
		
		System.out.println();
		int pageCounter=0;
		for(int i=1; i<=numOfRecords; i++) {
			if(i%10==1) {
				pageCounter++;
				System.out.println("Reading page #"+pageCounter+" ...");
			}
		}
		raf.close();
		System.out.println("\nSUCCESS! The record has been inserted successfuly to the page #"+(pageCounter));
	}
	
	public void readTypeHeader(String typeName) throws IOException {		//this function read the typeheader

		File f2 = new File("Files/" + typeName + ".txt");
		RandomAccessFile raf = new RandomAccessFile(f2, "r");

		raf.seek(0);
		numOfRecords = raf.readInt();
		raf.seek(4);
		numOfFields = raf.readInt();

		//System.out.println("numRecord: "+numOfRecords+", num Field: "+numOfFields);
		fieldNames = new String[numOfFields];
		raf.seek(8);
		for(int i = 0; i < numOfFields; i++) {
			String popped = raf.readUTF();
			String temp = "";
			for(int j=0; j<12; j++) {
				if(popped.charAt(j) != '*') {
					temp += popped.charAt(j);
				}
			}
			fieldNames[i]=temp;
		}
		
		raf.close();
	}
	
	boolean deleteRecord(String typeName) throws IOException {				//This function delete a Record
		this.typeName = typeName;
		readTypeHeader(typeName);
		File f = new File("Files/" + typeName + ".txt");
		RandomAccessFile raf = new RandomAccessFile(f, "rw");
		System.out.print("\nrecord ID: ");
		int primaryKey = console.nextInt();

		numOfRecords--;
		raf.seek(0);
		raf.writeInt(numOfRecords);
		int tempCounter=1;
		int pageCounter=0;

		System.out.println();
		for(int k= 120; k<raf.length(); k+=numOfFields*12+numOfFields*2+5) {
			if(tempCounter%10==1) {
				pageCounter++;
				System.out.println("Reading page #"+ (pageCounter)+" ...");
			}
			raf.seek(k);
			int poppedID = raf.readInt();
			int isDeleted = raf.readByte();
			tempCounter++;
			if(isDeleted==1)
				continue;
			if(poppedID == primaryKey) {
				raf.seek(raf.getFilePointer()-1);
				raf.writeByte(1);
				raf.close();
				int i;
				System.out.println("SUCCESS! The record deleted successfuly from the page #"+pageCounter);
				return true;
			}
			
		}
		int i;
		System.out.println("Reading page #1 ...");
		for(i=1; i<numOfRecords/10+1; i++) {
			System.out.println("Reading page #"+i+" ...");
		}
		raf.close();
		return false;
	}
	
	void listRecords(String typeName) throws IOException {				//This function list all the records in the type

		File f = new File("Files/" + typeName + ".txt");
		RandomAccessFile raf = new RandomAccessFile(f, "r");

		readTypeHeader(typeName);

		if(numOfRecords == 0) {
			System.out.println("There is no record in this table!");
			return;
		}
		int counter=1;
		int tempCounter=1;
		int pageCounter=0;
		
		for(int k=120; k<raf.length(); k+=numOfFields*12+numOfFields*2+5) {
			if(tempCounter%10==1) {
				pageCounter++;
				System.out.println("\nReading page #"+ (pageCounter)+" ...\n");
			}
			tempCounter++;
			raf.seek(k);
			int recordID = raf.readInt();
			int isDeleted = raf.readByte();
			if(isDeleted==1)
				continue;
			System.out.println("\t"+counter+". recordID: "+recordID);
			for(int j=0; j<numOfFields; j++) {
				String popped = raf.readUTF();
				String temp = "";
				for(int i=0; i<popped.length(); i++) {
					if(popped.charAt(i)!='*')
						temp+=popped.charAt(i);
				}
				System.out.println("\t\t"+fieldNames[j]+": "+temp);
			}
			System.out.println();
			counter++;
			

		}
		raf.close();
	}
	
	boolean searchRecord(String typeName) throws IOException {					//This function search for a record
		this.typeName = typeName;
		File f = new File("Files/" + typeName + ".txt");
		RandomAccessFile raf = new RandomAccessFile(f, "rw");

		readTypeHeader(typeName); 	 
		if(numOfRecords==0) {
			raf.close();
			return false;
		}

		System.out.print("\nrecord ID: ");

		int primaryKey = console.nextInt();
		int tempCounter=1;
		int pageCounter=0;

		for(int k= 120; k<raf.length(); k+=numOfFields*12+numOfFields*2+5) {
			if(tempCounter%10==1) {
				pageCounter++;
				System.out.println("Reading page #"+pageCounter+" ...");
			}
			raf.seek(k);
			int poppedID = raf.readInt();
			int isDeleted = raf.readByte();
			tempCounter++;
			if(isDeleted == 1)
				continue;
			if(poppedID == primaryKey) {
				System.out.println("\trecordID: "+primaryKey);
				for(int j=0; j<numOfFields; j++) {
					String popped = raf.readUTF();
					String temp = "";
					for(int i=0; i<popped.length(); i++) {
						if(popped.charAt(i)!='*')
							temp+=popped.charAt(i);
					}
					System.out.println("\t\t"+fieldNames[j]+": "+temp);
				}
				raf.close();
				System.out.println("\nRecord has been found in the page #"+pageCounter+"!");
				return true;
			}
		}
		raf.close();
		return false;
	}
	
	boolean isRecordExists(int recordID, String typeName) throws IOException {			//This function check whether the record exists or not
		this.typeName = typeName;
		File f = new File("Files/" + typeName + ".txt");
		RandomAccessFile raf = new RandomAccessFile(f, "rw");
		readTypeHeader(typeName); 	 		
		int primaryKey = recordID;

		for(int k= 120; k<raf.length(); k+=numOfFields*12+numOfFields*2+5) {
			raf.seek(k);
			int poppedID = raf.readInt();
			int isDeleted = raf.readByte();
			if(isDeleted == 1)
				continue;
			if(poppedID == primaryKey) {
				raf.close();
				return true;
			}
		}
		raf.close();
		return false;
	}
}

