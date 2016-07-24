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

    private static final String url = "jdbc:mysql://localhost:3306/testdb";
    private static final String user = "root";
    private static final String password = "J@c0bsl0om";
    static boolean done = false;
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws InterruptedException {
        
        Dialogue dialogue = new Dialogue();
        dialogue.setVisible(true);

        while(!done)Thread.sleep(1);  /**
                                       * Allows updated file to be used when
                                       * getting card info (stops 
                                       * next step until GUI is closed)
                                       */
        
        System.out.println(readFromFile());
        
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
            e.printStackTrace();
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
            e.printStackTrace();
        } finally {
            try {
                reader.close();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
        //Default, this should never be executed
        return "";
    }
    
    private static String parseInfo(String rawData){
        
        return "";
    }
    
} //end class
