/*
 * Author: Cemal AYTEKÝN
 */
import java.io.File;
import java.io.IOException;
import java.io.RandomAccessFile;
import java.util.Scanner;

//TODO 2: main menuye dönüþ?
//TODO 3: comments
//TODO 4: all possible errors checking
//TODO 6: 10mb memory check
public class SystemCatalog {
	Scanner console = new Scanner(System.in);
	RandomAccessFile syscat;
	public SystemCatalog() throws IOException{

		File f = new File("syscat.txt"); 
		//Check whether this is the first time to run database management system
		boolean success = (new File("Files")).mkdir();
		syscat = new RandomAccessFile(f, "rw");
		syscat.seek(0);
		if(success)
			syscat.writeInt(0);

		System.out.println("Welcome to DB Manager System!");
		System.out.println();
		showMenu();
	}
	void showMenu() throws IOException {							//It pop ups the DB MENU

		System.out.println("..:: DB MENU  ::..");
		System.out.println();
		System.out.println("Type Operations");
		System.out.println("(1) Create Type");
		System.out.println("(2) Delete Type");
		System.out.println("(3) List Types");
		System.out.println();
		System.out.println("Record Operations");
		System.out.println("(4) Insert a Record");
		System.out.println("(5) Delete a Record");
		System.out.println("(6) List all Records");
		System.out.println("(7) Search for a Record");
		System.out.println("(0) Exit");
		System.out.println();
		System.out.print("Please select an operation: ");

		//Check the input format
		int opr=-1;	
		try{
			opr = Integer.parseInt(console.next());
		}
		catch(NumberFormatException e) {
			opr = -1;
		}	
		while(opr<0 | opr >8) {
			System.out.print("Please enter a valid option: ");
			try{
				opr = Integer.parseInt(console.next());
			}
			catch(NumberFormatException e) {
				opr = -1;
			}	
		}

		switch(opr) {
		case 0:
			System.out.println("Good Bye..");
			return;
		case 1:
			createType();
			break;
		case 2:
			deleteType();
			break;
		case 3:
			listTypes();
			break;
		case 4:
			createRecord();
			break;
		case 5:
			deleteRecord();
			break;
		case 6:
			listRecords();
			break;
		case 7:
			searchRecord();
			break;
		}
		returnMenu();

	}
	void createType() throws IOException {							// This function create a Type
		System.out.print("type name: ");
		String typeName = console.next();
		
		//check whether the type exists or the length is longer than 12
		while(isTypeExist(typeName) | typeName.length()>12) {
			if(typeName.length()>12) 
				System.out.println("ERROR: Type names cannot be more than 12 characters long");
			else
				System.out.println("ERROR: Type already exists");

			System.out.print("Enter another type name: ");
			typeName = console.next();
		}

		Type type = new Type();
		type.createType(typeName);

		syscat.seek(0);								
		int typeCounter = syscat.readInt();
		typeCounter++;
		syscat.seek(0);
		syscat.writeInt(typeCounter);				//increment the number of types

		syscat.seek(syscat.length());

		while(typeName.length()!=12)
			typeName+="*";							//complete the string size to 12 by adding *

		syscat.writeUTF(typeName);  				//typeName 12 byte
		syscat.writeInt(type.numOfFields); 			// number of fields 4 byte 
		syscat.writeByte(0);						//set isDeleted to false

		for(int i = 0; i < type.numOfFields; i++) 
			syscat.writeUTF(type.fieldNames[i]); 	

		for(int i = type.numOfFields; i<8; i++)
			syscat.writeUTF("************");		//complete the remaining fields area 

		String temp="";
		for(int i=0; i<typeName.length(); i++) {
			if(typeName.charAt(i)!='*')
				temp+=typeName.charAt(i);
		}
		System.out.println(temp+" has been created successfuly");
	}
	void deleteType() throws IOException {			// This function delete a Type
		System.out.print("\ntype name: ");

		String typeName = console.next();
		int shift = 0;

		while(!isTypeExist(typeName)) {				// check whether the type exists
			System.out.println("\nERROR: Type does not exist!\n");
			System.out.print("Enter another type name: ");
			typeName = console.next();
		}

		syscat.seek(0);

		int numberOfTypes = syscat.readInt();
		numberOfTypes--;
		syscat.seek(0);
		syscat.writeInt(numberOfTypes);				// decrement the number of Types

		for(int k=4; k<syscat.length(); k+=131) {
			syscat.seek(k);
			String poppedTypeName = syscat.readUTF();
			int numOfRecords = syscat.readInt();
			int isDeleted = syscat.readByte();		//if the type is deleted, skip it
			if(isDeleted == 1)
				continue;
			String temp = "";
			for(int i=0; i<12; i++) {
				if(poppedTypeName.charAt(i) != '*') {
					temp += poppedTypeName.charAt(i);
				}
			}
			if(temp.equals(typeName)) {
				syscat.seek(syscat.getFilePointer()-1);
				syscat.write(1);					//set isDeleted to true;
				shift = k;
				break;
			}
		}		
		
		/*
		Byte[] remain = new Byte[((numberOfTypes+1)*130)+4-shift-130];
		for(int i=0; i<remain.length; i++) {
			syscat.seek(shift+130+i);
			remain[i]=syscat.readByte();
		}		
		syscat.seek(shift);
		for(int i=0; i<remain.length; i++) {
			syscat.seek(shift+i);
			syscat.writeByte(remain[i]);
		}
		*/
		File f1 = new File("Files/" + typeName + ".txt");
		f1.createNewFile();
		if(f1.delete())										//Delete the file of the type
		System.out.println(typeName+": Type is deleted!\n"); 
		else
			System.out.println("An error has occured!");


	}
	void listTypes() throws IOException {					//This function list all the types
		syscat.seek(0);
		int numberOfTypes = syscat.readInt();
		if(numberOfTypes == 0){
			System.out.println("\nThere is no type!");
			return;
		} 
		else 
			System.out.println("\n" + numberOfTypes + " type found!\n");

		int counter=1;
		for(int k=4; k<syscat.length(); k+=131) {
			syscat.seek(k);
			String popped = syscat.readUTF();
			int numOfFields = syscat.readInt();
			int isDeleted = syscat.readByte();
			
			if(isDeleted==1)
				continue;
			String temp = "";
			for(int j=0; j<12; j++) {
				if(popped.charAt(j) != '*') {
					temp += popped.charAt(j);
				}
			}
			System.out.print("\t"+counter+". "+temp.toUpperCase()+": ");	
			String popped2 = syscat.readUTF();
			String temp2 = "";
			for(int j=0; j<12; j++) {
				if(popped2.charAt(j) != '*') {
					temp2 += popped2.charAt(j);
				}
			}
			System.out.print(temp2);

			for(int m=1; m<numOfFields; m++) {
				popped2 = syscat.readUTF();
				temp2 = "";
				for(int j=0; j<12; j++) {
					if(popped2.charAt(j) != '*') {
						temp2 += popped2.charAt(j);
					}
				}
				System.out.print(", "+temp2);
			}
			System.out.println("\n");
			counter++;
		}

	}
	
	boolean isTypeExist(String typeName) {						//this function check whether the type exists
		File dir = new File("Files");
		String[] files = dir.list();
		for(int i = 0; i < files.length; i++) {
			if (files[i].equals(typeName + ".txt")) 
				return true;		
		}
		return false;
	}
	
	void returnMenu() throws IOException {						//this function help user to go back to menu
		System.out.print("\nPress 1 to go back to Main Menu: ");
		int opt = console.nextInt();
		while(opt != 1) {
			System.out.print("ERROR: Press 1 to go back to Main Menu: ");
			opt = console.nextInt();
		}
		showMenu();
	}
	
	void createRecord() throws IOException {					// this function create a record
		System.out.print("type name:");

		String typeName = console.next();
		while(!isTypeExist(typeName)) {							//if the type does not exists no further
			System.out.println("\nERROR: There is no type with this name!: "+typeName);
			System.out.println("Press 1 to see the list of types OR write another type name");
			typeName = console.next();
			if(typeName.equals("1")) {
				listTypes();
				createRecord();
				return;
			}
		}

		Type type = new Type();
		type.insertRecord(typeName);	
	}
	
	void deleteRecord() throws IOException {					//This function delete a Record
		System.out.print("\ntype name:");
		String typeName = console.next();
		while(!isTypeExist(typeName)) {
			System.out.println("\nERROR: There is no type with this name!: "+typeName);
			System.out.println("Press 1 to see the list of types OR write another type name");
			typeName = console.next();
			if(typeName.equals("1")) {
				listTypes();
				deleteRecord();
				return;
			}
		}

		Type type = new Type();
		if(type.deleteRecord(typeName)) {
			System.out.println();
		}	
		else
			System.out.println("\nERROR: No such record found!");

	}
	
	void listRecords() throws IOException {						//This function list all records in a type
		System.out.print("\ntype name:");
		String typeName = console.next();
		while(!isTypeExist(typeName)) {
			System.out.println("\nERROR: There is no type with this name!: "+typeName);
			System.out.println("Press 1 to see the list of types OR write another type name");
			typeName = console.next();
			if(typeName.equals("1")) {
				listTypes();
				listRecords();
				return;
			}
		}

		Type type = new Type();
		type.listRecords(typeName);	
	}
	
	void searchRecord() throws IOException {					//This function search a record
		System.out.print("\ntype name:");
		String typeName = console.next();
		while(!isTypeExist(typeName)) {
			System.out.println("\nERROR: There is no type with this name!: "+typeName);
			System.out.println("Press 1 to see the list of types OR write another type name");
			typeName = console.next();
			if(typeName.equals("1")) {
				listTypes();
				searchRecord();
				return;
			}
		}

		Type type = new Type();
		if(type.searchRecord(typeName)) {
			System.out.println();
		}	
		else
			System.out.println("\n\nNo such record found!");
	}
}
