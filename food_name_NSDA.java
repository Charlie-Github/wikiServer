import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.regex.Matcher;
import java.util.regex.Pattern;


public class food_name_NSDA {
	private static File inputfile = new File("FOOD_DES_NSDA.txt");
	private static File outputfile = new File("FOOD_LIST_NSDA_8000.txt");
	
	public static void main(String[] args) throws IOException {
		FileReader reader = new FileReader(inputfile);
		BufferedReader br = new BufferedReader(reader);
		
		FileWriter writer = new FileWriter(outputfile);
		BufferedWriter bw = new BufferedWriter(writer);
		
		System.out.println("start：");
		
		String s1 = null;
		while((s1=br.readLine()) != null){
			
		//~01020~^~0100~^~Cheese, fontina~^~CHEESE,FONTINA~^~~^~~^~Y~^~~^0^~~^6.38^4.27^8.79^3.87
		String prefix_pattern = "^~.*~\\^~.*~\\^~";
		//String post_pattern = "~\\^.*\\^.*\\^.*\\^.*\\^.*\\^.*\\^.*\\^.*\\^.*\\^.*$";
		s1 = s1.replaceAll(prefix_pattern, "");//.replaceAll(post_pattern, "");
							
			
			
			bw.write(s1);
        	bw.write("\r\n");
			
			
		}
		br.close();
        reader.close();
        bw.close();
        writer.close();
        System.out.println("Stop.");
		
		
	}
	
}
