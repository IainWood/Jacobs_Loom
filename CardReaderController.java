package loginpage;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
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
    
    private static String track1 = "";
    private static String track2 = "";
    private static String track3 = "";
    
    @FXML
    private void initialize(){
        
    }
    
    /**
     * Reads the employee's card
     * activated when card is slid however, possible explanation is 
     * hidden return character on end of mag stripe
     * @param evt - click of the Read Card button, is automatically
     */
    @FXML
    public void readCardButton(ActionEvent evt){

        try {
            String filePath = "C:\\Users\\Marcus Woodburn\\Documents\\";
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

                //Loads next window
                Stage primaryStage = LoginPage.primaryStage;
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
            Logger.getLogger(LoginPage.class.getName()).log(Level.SEVERE, null, ex);
        }
            
    } //readCardButton
    
    /**
     * Makes an error message appear if the input is invalid
     * 
     * @param errMessage - the error message to be displayed
     */
    public void toggleError(String errMessage){
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
        
        String seed = "password";
        
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
        String seed = "password";
        
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
            filePath = "C:\\Users\\".concat(computerName).concat("\\Documents\\");
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
                    toggleError("Error reading card, please try again");
                } //end try-catch
            
            }else{
                toggleError("Error reading card, please try again");
            }
            
        } //end if
        
    } //end parseTracks
    
} //end class
