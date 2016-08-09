package loginpage;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.TimeZone;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.scene.image.Image;
import javafx.stage.Stage;
import org.jasypt.encryption.pbe.StandardPBEStringEncryptor;

/**
 * @author Iain Woodburn
 */
public class CardReaderController {
    
    @FXML private PasswordField password_field2;
    @FXML private Label errorLabel;
    
    //For mySQL
    private Connection myConn;
    private Statement myStatement;
    private Statement myStatement2;
    private ResultSet myRs;
    private static final String URL = "jdbc:mysql://localhost:3306/new_schema?autoReconnect=true&useSSL=false";
    private static final String USERNAME = "root";
    private static final String PASSWORD = "J@c0bsl0om";
    
    private static final Integer EMP_FORMATTER = 1000000;
    
    public static String track1 = "";
    public static String track2 = "";
    public static String track3 = "";
    
    /**
     * Reads the employee's card
     * activated when card is slid however, possible explanation is 
     * hidden return character on end of mag stripe
     * @param evt - click of the Read Card button, is automatically
     */
    @FXML
    private void readCardButton(ActionEvent evt){

        try {
            String filePath = "C:\\Users\\Marcus Woodburn\\Documents\\Jacob's Loom\\";
            String fileName = "employeeCardInfo.txt";
            
            //Gets the string from the password box
            String password = password_field2.getText();
            
            //Acts as a test to see if text is valid,
            //if not, this displays the error and does
            //not allow the form to close
            if(!validateInput(password)){
                toggleError("Error reading card, please try again");
            }else{

                //Encrypts string directly after it is collected and BEFORE it is passed or written to the file
                password = encrypt(password);
                writeToFile(password , filePath , fileName);

                //Seperates the information into three tracks
                parseTracks(readFromFile());

                //Records the swipe in the logs
                logData();
                
                //Loads next window
                Stage primaryStage = LoginPageController.primaryStage;
                FXMLLoader loader = new FXMLLoader(getClass().getResource("EmployeeInfo.fxml"));
                loader.load();

                Parent root = FXMLLoader.load(getClass().getResource("EmployeeInfo.fxml"));
                Scene scene = new Scene(root);
                primaryStage.setTitle("Employee Info");
                primaryStage.setScene(scene);
                primaryStage.getIcons().add(new Image(getClass().getResourceAsStream("images/jacobsloomicon.png")));
                primaryStage.show();
            } //end if
            
        } catch (IOException ex) {
            Logger.getLogger(LoginPageController.class.getName()).log(Level.SEVERE, null, ex);
        }
            
    } //readCardButton
    
    /**
     * Gets a connection to the database
     */
    private void getConnectionToDB(){
        
        try {
            myConn = DriverManager.getConnection(URL, USERNAME , PASSWORD);
            //Creates a statement
            myStatement = myConn.createStatement();
            myStatement2 = myConn.createStatement();
        } catch (SQLException ex) {
            Logger.getLogger(LoginPageController.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    } //end getConnectionToDB
    
    /**
     * Writes the time of the swipe, the card holders name, and the date
     */
    @SuppressWarnings("ConvertToTryWithResources")
    private void logData(){
        
        try{
            
            DateFormat dateFormat = new SimpleDateFormat("MM/dd/yyyy HH:mm:ss");
            
            Calendar calendar = Calendar.getInstance(TimeZone.getTimeZone("GMT"));
            String date = dateFormat.format(calendar.getTime());
            
            //Gets a connection to the database
            getConnectionToDB();
            
            String name = "";
            String user = DataSharer.getUsername();
            
            try {
                String firstName = "";
                String lastName = "";
                
                //Will get the employee who matches the card that was just swiped
                myRs = myStatement.executeQuery("SELECT * FROM employees WHERE emp_id='" + "1" + "'");
                
                while(myRs.next()){
                    firstName = myRs.getString("emp_first_name");
                    lastName = myRs.getString("emp_last_name");
                }
                
                name = lastName + ", " + firstName + "\t\tEmployee ID: " + (EMP_FORMATTER + Integer.parseInt(track1));
                
            } catch (SQLException ex) {
                Logger.getLogger(CardReaderController.class.getName()).log(Level.SEVERE, null, ex);
            }
            
            File file = new File("C:\\Users\\Marcus Woodburn\\Documents\\Jacob's Loom\\Card Reader Log.txt");
            
            if(!file.exists()){
                file.createNewFile();
            }
            
            FileWriter fw = new FileWriter(file.getAbsoluteFile(), true);
            BufferedWriter bw = new BufferedWriter(fw);
            if(!name.isEmpty() && !date.isEmpty() && !user.isEmpty()){
                bw.write("User: " + user);
                bw.newLine();
                bw.write(name);
                bw.newLine();
                bw.write(date);
                bw.newLine();
            } else {
                //Causes the error message to toggle
                throw new IOException();
            }
            bw.close();
            
        } catch (IOException e){
            toggleError("ERROR: Please try again");
        }
        
    } //end logData
    
    /**
     * Makes an error message appear if the input is invalid
     * 
     * @param errMessage - the error message to be displayed
     */
    private void toggleError(String errMessage){
        errorLabel.setText(errMessage);
        errorLabel.setVisible(true);
    } //end toggleError
    
    /**
     * Tests if the input is valid
     * @param rawData
     * @return true if input contains three '?' false otherwise
     */
    private boolean validateInput(String rawData){
        int numOfQuestionMarks = 0;
        
        for(int i = 0; i < rawData.length(); i++){
                if(rawData.charAt(i) == '?'){
                    numOfQuestionMarks++;
                }

        } //end for 
        return numOfQuestionMarks == 3;
    } //end validateInput
    
    /**
     * Encrypts a string, using seed keyword "password"
     * @param rawString - Un-encrypted data
     * @return the encrypted string
     */
    private String encrypt(String rawString){
        //Seed used to decrypt must match this
        String seed = "enigma";
        
        StandardPBEStringEncryptor encryptor = new StandardPBEStringEncryptor();
        encryptor.setPassword(seed);
        return encryptor.encrypt(rawString);
    } //end encrypt
    
    /**
     * Decrypts the string AFTER is is read from the file by the method 'readFromFile'
     * @param encryptedString
     * @return decrypted string
     */
    private String decrypt(String encryptedString){
        //Seed must be same as what was used to encrypt origially
        String seed = "enigma";
        
        StandardPBEStringEncryptor decryptor = new StandardPBEStringEncryptor();
        decryptor.setPassword(seed);
        
        //Decrypts and returns the raw string
        return decryptor.decrypt(encryptedString);
    } //end decrypt
    
    /**
     * Writes the employee's information to a file
     * @param text - the actual info, raw and unparsed
     * @param filepath - path to the file being written to
     * @param filename - name of file being written to
     * @return true if writing is successful, false otherwise
     */
    private boolean writeToFile(String text, String filepath, String filename){
        
        try { 
          //Creates new file, even if one already exists, good for security
          FileWriter fWriter = new FileWriter(filepath.concat(filename)); 
            try (BufferedWriter writer = new BufferedWriter(fWriter)) {
                writer.write(text);
                writer.newLine();
            }

        } catch (Exception e) {
            toggleError("Error reading card, please try again");
        }
        
        return false;
        
    } //end writeToFile
    
    /**
     * Reads the employee's card info from the file
     * @return employee card information, not parsed
     */
    @SuppressWarnings("null")
    private String readFromFile(){
        //Gets the username of the computer for the file path
        String computerName = System.getProperty("user.name");
        BufferedReader reader = null;
        String filePath = "";
        String fileName = "";
        
        try{
            //Use concat for error handeling
            filePath = "C:\\Users\\".concat(computerName).concat("\\Documents\\Jacob's Loom\\");
            fileName = "employeeCardInfo.txt";
        }catch (NullPointerException e){
            toggleError("Error reading card, please try again");
        }

        try {
            
            File file = new File(filePath.concat(fileName));
            reader = new BufferedReader(new FileReader(file));

            String nextLineinFile;
            while ((nextLineinFile = reader.readLine()) != null) {
                    nextLineinFile = decrypt(nextLineinFile); //Decrypts the line into the raw information
                   return nextLineinFile;
            }

        } catch (IOException e) {
            toggleError("Error reading card, please try again");
        } finally {
            try {
                reader.close();
            } catch (IOException | NullPointerException e) {
                toggleError("Error reading card, please try again");
            }
        }
        //Default, this should never be executed
        return "";
    } //readFromFile
    
    /**
     * Parses the information found in the card, after
     * it is decrypted. The format for the raw data is as follows
     * %track1?;track2?+track3?
     * @param rawData the data, decrypted, from readFromFile()
     */
    private void parseTracks(String rawData){
        //rawData = %track1?;track2?+track3?   total:
        //          012345678901234567890123   23  
        
        if(rawData != null && !rawData.isEmpty()){
            
            int numOfQuestionMarks = 0;
            
            for(int i = 0; i < rawData.length(); i++){
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
                    DataSharer.setTrack1(track1);
                    
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
                    DataSharer.setTrack2(track2);

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
                    DataSharer.setTrack3(track3);

                }catch (Exception e){
                    toggleError("Error reading card, please try again");
                } //end try-catch
            
            }else{
                toggleError("Error reading card, please try again");
            }
            
        } //end if
        
    } //end parseTracks
    
} //end class
