package readcard;

//imports
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.jasypt.encryption.pbe.StandardPBEStringEncryptor;

/**
 * @author Iain Woodburn
 */
public class ReadCard {
    
    private static final Dialogue dialogue = new Dialogue();
    
    private static final String url = "jdbc:mysql://localhost:3306/myschema";
    private static final String user = "root";
    private static final String password = "J@c0bsl0om";
    
    private static String track1 = "";
    private static String track2 = "";
    private static String track3 = "";
    
    static boolean done = false;
    /**
     * @param args the command line arguments
     * @throws java.lang.InterruptedException
     */
    @SuppressWarnings("SleepWhileInLoop")
    public static void main(String[] args) throws InterruptedException {
        
        dialogue.pack();
        dialogue.setLocationRelativeTo(null); //Centers the window
        dialogue.setVisible(true);
        dialogue.toggleError("");
        
        
        while(!done)Thread.sleep(1);  /**
                                       * Allows updated file to be used when
                                       * getting card info (stops 
                                       * next step until GUI is closed)
                                       */
        
        System.out.println(readFromFile());
        parseTracks(readFromFile());
        System.out.println("Track 1: " + track1);
        System.out.println("Track 2: " + track2);
        System.out.println("Track 3: " + track3);
        
        Connection con = null;
        Statement st = null;
        ResultSet rs = null;

        try {
            
            con = DriverManager.getConnection(url, user, password);
            st = con.createStatement();
            rs = st.executeQuery("SELECT VERSION()");

            if (rs.next()) {
                
                System.out.println(rs.getString(1));
            }

        } catch (SQLException ex) {
        
            Logger lgr = Logger.getLogger(ReadCard.class.getName());
            lgr.log(Level.SEVERE, ex.getMessage(), ex);

        } finally {
            
            try {
                
                if (rs != null) {
                    rs.close();
                }
                
                if (st != null) {
                    st.close();
                }
                
                if (con != null) {
                    con.close();
                }

            } catch (SQLException ex) {
                
                Logger lgr = Logger.getLogger(ReadCard.class.getName());
                lgr.log(Level.WARNING, ex.getMessage(), ex);
            }
        }
        
    } //end main
    
    /**
     * Decrypts the string AFTER is is read from the file by the method 'readFromFile'
     * 
     * @param encryptedString
     * @return decrypted string
     */
    private static String decrypt(String encryptedString){
        //Seed must be same as what was used to encrypt origially
        String seed = "password";
        
        StandardPBEStringEncryptor decryptor = new StandardPBEStringEncryptor();
        decryptor.setPassword(seed);
        
        //Decrypts and returns the raw string
        return decryptor.decrypt(encryptedString);
    }
    
    /**
     * Reads the employee's card info from the file
     * 
     * @return employee card information, not parsed
     */
    @SuppressWarnings("null")
    private static String readFromFile(){
        //Gets the username of the computer for the file path
        String name = System.getProperty("user.name");
        BufferedReader reader = null;
        String filePath = "";
        String fileName = "";
        
        try{
            //Use concat for error handeling
            filePath = "C:\\Users\\".concat(name).concat("\\Documents\\");
            fileName = "employeeCardInfo.txt";
        }catch (NullPointerException e){
            dialogue.toggleError("Error reading card, please try again");
        }

        try {
            
            File file = new File(filePath.concat(fileName));
            reader = new BufferedReader(new FileReader(file));

            String line;
            while ((line = reader.readLine()) != null) {
                    line = decrypt(line); //Decrypts the line into the raw information
                   return line;
            }

        } catch (IOException e) {
            dialogue.toggleError("Error reading card, please try again");
        } finally {
            try {
                reader.close();
            } catch (IOException | NullPointerException e) {
                dialogue.toggleError("Error reading card, please try again");
            }
        }
        //Default, this should never be executed
        return "";
    }
    
    /**
     * Parses the information found in the card, after
     * it is decrypted. The format for the raw data is as follows
     * %track1?;track2?+track3?
     * 
     * @param rawData the data, decrypted, from readFromFile()
     */
    private static void parseTracks(String rawData){
        //rawData = %track1?;track2?+track3?   total:
        //          012345678901234567890123   23  
        
        if(rawData != null && !rawData.isEmpty()){
            
            int numOfQuestionMarks = 0;
            
            for(int i = 0; i < rawData.length(); i++){
                System.out.println(rawData.charAt(i));
                    if(rawData.charAt(i) == '?'){
                        numOfQuestionMarks++;
                    }

            } //end for
            
            if(numOfQuestionMarks == 3){
            
                try{

                    int beginT1 = 1;
                    int endT1 = -1;

                    for(int i = 0; i < rawData.length(); i++){
                           
                        if(rawData.charAt(i) == '?'){
                            endT1 = i;
                            break;
                        }

                    }

                    track1 = rawData.substring(beginT1 , endT1);

                    int beginT2 = 1;
                    int endT2 = -1;

                    rawData = rawData.substring(endT1+1);

                    for(int i = 0; i < rawData.length(); i++){

                        if(rawData.charAt(i) == '?'){
                            endT2 = i;
                            break;
                        }

                    }

                    track2 = rawData.substring(beginT2 , endT2);

                    int beginT3 = 1;
                    int endT3 = -1;

                    rawData = rawData.substring(endT2+1);

                    for(int i = 0; i < rawData.length(); i++){

                        if(rawData.charAt(i) == '?'){
                            endT3 = i;
                            break;
                        }

                    }

                    track3 = rawData.substring(beginT3 , endT3);

                }catch (Exception e){
                    dialogue.toggleError("Error reading card, please try again");
                } //end try-catch
            
            }else{
                dialogue.toggleError("Error reading card, please try again");
            }
            
        } //end if
        
    } //end parseTracks
    
} //end class
