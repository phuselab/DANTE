% Dato che il rumore in una di un'annotazione può variare
% significativamente da un'annotatore ad un'altro, è ragionevole introdurre
% una valutazione individuale di confidenza per ogni singolo annotatore.

% La somiglianza tra ogni punto di un'annotazione e la sequenza MLE può
% essere vista come la misura di confidenza di un singolo annotatore. r

function EWE = EvaluatorWeightedEstimator(samplesMatrix, MLE)
%      samplesMatrix= [1 2 1; 1 3 2; 2 1 0; 0 -4 -5];
%      MLE = sum(transpose(samplesMatrix))/3;

    meanMLE = mean(MLE);    
    
    r = zeros(1, size(samplesMatrix,2));
    for k=1 : size(samplesMatrix,2) % per ogni annotatore
        meanSingleEvaluator = mean(samplesMatrix(:,k));
        A = sum((samplesMatrix(:,k) - meanSingleEvaluator).* (MLE - meanMLE));
        B = sqrt(sum((samplesMatrix(:,k) - meanSingleEvaluator).^2)).* sqrt(sum((MLE - meanMLE).^2));
        %Correlation Coefficent
        r(1, k) = A/B;
    end
    
    EWE = (samplesMatrix * r')/sum(r);
end